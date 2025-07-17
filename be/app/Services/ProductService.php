<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Helpers\StringHelper;
use App\Repositories\ProductRepository;
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

        // Trả về thông tin sản phẩm đã thêm mới
        return $this->repo->create($data);
    }

    public function show($id)
    {
        return $this->repo->findById($id);
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        $data = $request->validated();
        // Tự động xử lý viết hoa chữ cái đầu tiên
        $data['name'] = StringHelper::mbUcFirst($data['name']);
        // Tự động thêm slug theo name
        $data['slug'] = Str::slug($data['name']);
        // Cập nhật danh mục
        $this->repo->update($id, $data);
        // Trả về thông tin danh mục đã cập nhật
        return $this->repo->findById($id);
    }

    public function delete(int $id)
    {
        $category = $this->repo->findById($id);
        if (!$category) {
            return null;
        }
        $this->repo->delete($id);
        return $category;
    }
}
