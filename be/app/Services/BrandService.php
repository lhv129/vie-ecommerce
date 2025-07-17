<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Helpers\StringHelper;
use App\Repositories\BrandRepository;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;

class BrandService
{
    protected $repo;
    public function __construct(BrandRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll()
    {
        return $this->repo->getAll();
    }

    public function create(StoreBrandRequest $request)
    {
        $data = $request->validated();
        // Tự động xử lý viết hoa chữ cái đầu tiên
        $data['name'] = StringHelper::mbUcFirst($data['name']);
        // Tự động thêm slug theo name
        $data['slug'] = Str::slug($data['name']);

        // Xử lý ảnh
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            // Tạo ngẫu nhiên tên ảnh 12 kí tự
            $imageName = Str::random(12) . "." . $file->getClientOriginalExtension();
            // Đường dẫn ảnh
            $imageDirectory = 'images/brands/';

            $file->move($imageDirectory, $imageName);
            $path_image   = 'http://127.0.0.1:8000/' . ($imageDirectory . $imageName);

            $data['image'] = $path_image;
            $data['fileImage'] = $imageName;
        }

        // Trả về thông tin danh mục sản phẩm đã thêm mới
        return $this->repo->create($data);
    }

    public function show($id)
    {
        return $this->repo->findById($id);
    }

    public function update(UpdateBrandRequest $request, int $id)
    {
        $data = $request->validated();
        // Tự động xử lý viết hoa chữ cái đầu tiên
        $data['name'] = StringHelper::mbUcFirst($data['name']);
        // Tự động thêm slug theo name
        $data['slug'] = Str::slug($data['name']);

        // Lấy dữ liệu hiện tại của sub_category
        $brand = $this->repo->findById($id);
        // Xử lý ảnh
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = Str::random(12) . '.' . $file->getClientOriginalExtension();
            $imageDirectory = 'images/brands/';
            $file->move($imageDirectory, $imageName);

            // Xóa ảnh cũ nếu tồn tại
            $oldImagePath = public_path($imageDirectory . $brand->fileImage);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            $path_image = 'http://127.0.0.1:8000/' . ($imageDirectory . $imageName);
            $data['image'] = $path_image;
            $data['fileImage'] = $imageName;
        } else {
            // Không có ảnh mới → giữ nguyên ảnh cũ
            $data['image'] = $brand->image;
            $data['fileImage'] = $brand->fileImage;
        }

        // Cập nhật danh mục sản phẩm
        $this->repo->update($id, $data);
        // Trả về thông tin danh mục đã cập nhật
        return $this->repo->findById($id);
    }

    public function delete(int $id)
    {
        $brand = $this->repo->findById($id);
        if (!$brand) {
            return null;
        }
        $this->repo->delete($id);
        return $brand;
    }
}
