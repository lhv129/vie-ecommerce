<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SubCategoryService;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    protected $service;
    public function __construct(SubCategoryService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $categoryId = $request->category_id;
        return $this->responseCommon(200, 'Lấy thành công danh sách danh mục con', $this->service->getAll($categoryId));
    }

    public function store(StoreSubCategoryRequest $request)
    {
        return $this->responseCommon(201, 'Thêm mới thành công danh mục con', $this->service->create($request));
    }

    public function show(int $id)
    {
        return $this->responseCommon(201, 'Tìm thành công danh mục con', $this->service->show($id));
    }

    public function update(UpdateSubCategoryRequest $request, int $id)
    {
        return $this->responseCommon(200, 'Cập nhật danh mục con thành công', $this->service->update($request, $id));
    }

    public function destroy(int $id)
    {
        return $this->responseCommon(200, 'Xóa danh mục con thành công', $this->service->delete($id));
    }
}
