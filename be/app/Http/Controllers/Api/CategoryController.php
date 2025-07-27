<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    protected $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->responseCommon(200, 'Lấy thành công danh sách danh mục', $this->service->getAll());
    }

    public function store(StoreCategoryRequest $request)
    {
        return $this->responseCommon(201, 'Thêm mới danh mục thành công', $this->service->create($request));
    }

    public function show(int $id)
    {
        return $this->responseCommon(201, 'Tìm thành công danh mục', $this->service->show($id));
    }

    public function update(UpdateCategoryRequest $request, int $id)
    {
        return $this->responseCommon(200, 'Cập nhật danh mục thành công', $this->service->update($request, $id));
    }

    public function destroy(int $id)
    {
        $category = $this->service->delete($id);
        if (!$category) {
            return $this->responseCommon(200, 'Danh mục không tồn tại, vui lòng kiểm tra lại', []);
        } else {
            return $this->responseCommon(200, 'Xóa danh mục thành công', []);
        }
    }
}
