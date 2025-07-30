<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use App\Helpers\StringHelper;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductService
{
    protected $repo;
    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll()
    {
        return $this->repo->getAll();
    }

    public function create(StoreProductRequest $request)
    {
        $data = $request->validated();
        // Tự động xử lý viết hoa chữ cái đầu tiên
        $data['name'] = StringHelper::mbUcFirst($data['name']);
        // Tự động thêm slug theo name
        $data['slug'] = Str::slug($data['name']);
        $product = $this->repo->create($data);

        // Xử lý mảng ảnh
        if ($request->hasFile('images')) {
            $this->createProductImages($product, $request->images);
        }

        // Trả về thông tin sản phẩm đã thêm mới cùng với các ảnh của nó
        // Sử dụng load() để eager load mối quan hệ 'images' trước khi trả về
        $product->load('images');
        return $product;
    }

    public function show($id)
    {
        return $this->repo->getOne($id);
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        $data = $request->validated();
        $original = $this->repo->findById($id);

        // Tự động viết hoa chữ cái đầu tiên
        $data['name'] = StringHelper::mbUcFirst($data['name']);
        $data['slug'] = Str::slug($data['name']);

        // Kiểm tra có thay đổi ảnh hoặc tên không
        $isNameChanged = $data['name'] !== $original->name;
        $hasNewImages = $request->hasFile('images');

        // Loại bỏ images khỏi data trước khi update
        unset($data['images']);

        // Cập nhật DB
        $this->repo->update($id, $data);
        $product = $this->repo->findById($id); // Load lại để đảm bảo thông tin mới

        if ($isNameChanged || $hasNewImages) {
            // Nếu đổi tên và không có ảnh mới → chỉ di chuyển ảnh cũ
            if ($isNameChanged && !$hasNewImages) {
                $this->moveProductImageFolder($original->slug, $product->slug);
                $this->updateImagePathsInDb($product);
            } else {
                // Trường hợp có ảnh mới hoặc vừa đổi tên vừa có ảnh → xóa ảnh cũ như cũ
                $this->deleteOldProductImages($original);

                if ($hasNewImages) {
                    $this->createProductImages($product, $request->images);
                }
            }
        }


        $product->load('images');
        return $product;
    }


    public function delete(int $id)
    {
        return $this->repo->delete($id);
    }

    protected function createProductImages($product, array $imageFiles)
    {

        // Lấy slug của sản phẩm để tạo thư mục riêng
        $productSlug = $product->slug;

        // Định nghĩa thư mục lưu trữ ảnh trong public dựa trên slug của sản phẩm
        $imageDirectory = 'images/products/' . $productSlug . '/'; // Thêm slug vào đường dẫn

        foreach ($imageFiles as $imageFile) {
            // Bước 1: Tạo tên ảnh ngẫu nhiên và duy nhất
            // Sử dụng hashName() để đảm bảo tính duy nhất
            $imageName = $imageFile->hashName();

            $destinationPath = public_path($imageDirectory); // Đường dẫn tuyệt đối đến thư mục lưu trữ

            // Đảm bảo thư mục đích tồn tại, nếu không thì tạo mới
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Bước 2: Di chuyển file vật lý vào thư mục đích trong public
            $imageFile->move($destinationPath, $imageName);

            // Bước 3: Lấy URL công khai của ảnh
            $imageUrl = asset($imageDirectory . $imageName);

            // Bước 4: Lưu thông tin ảnh vào bảng product_images
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $imageUrl,
                'fileImage' => $imageName,
            ]);
        }
    }

    protected function deleteOldProductImages($product)
    {
        $productSlug = $product->slug;
        $directoryPath = public_path('images/products/' . $productSlug);

        // Kiểm tra và xóa folder vật lý
        if (File::exists($directoryPath)) {
            File::deleteDirectory($directoryPath);
        }

        // Xóa ở trong databases
        $this->repo->deleteOldProductImages($product->id);
    }

    protected function moveProductImageFolder($oldSlug, $newSlug)
    {
        $oldPath = public_path('images/products/' . $oldSlug);
        $newPath = public_path('images/products/' . $newSlug);

        if (File::exists($oldPath)) {
            // Tạo thư mục mới nếu chưa có
            if (!File::exists($newPath)) {
                File::makeDirectory($newPath, 0777, true);
            }

            // Di chuyển tất cả file
            File::moveDirectory($oldPath, $newPath);
        }
    }

    protected function updateImagePathsInDb($product)
    {
        $newSlug = $product->slug;
        $images = $product->images;

        foreach ($images as $image) {
            // fileImage chỉ là tên file, mình gắn lại URL dựa theo slug mới
            $newImageUrl = asset('images/products/' . $newSlug . '/' . $image->fileImage);
            $image->update(['image' => $newImageUrl]);
        }
    }
}
