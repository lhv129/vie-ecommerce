<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Helpers\StringHelper;
use App\Repositories\CategoryRepository;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryService
{
    protected $repo;

    public function __construct(CategoryRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll()
    {
        return $this->repo->all();
    }

    public function create(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        // Tự động xử lý viết hoa chữ cái đầu tiên
        $data['name'] = StringHelper::mbUcFirst($data['name']);
        // Tự động thêm slug theo name
        $data['slug'] = Str::slug($data['name']);
        // Trả về thông tin danh mục đã thêm mới
        return $this->repo->create($data);
    }

    public function show($id)
    {
        return $this->repo->findById($id);
    }

    public function update(UpdateCategoryRequest $request, int $id)
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
        $this->repo->delete($id);
        return $this->repo->delete($id);
    }
}
