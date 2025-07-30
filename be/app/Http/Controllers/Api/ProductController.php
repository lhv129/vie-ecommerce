<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $service;
    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->responseCommon(200, 'Lấy thành công danh sách sản phẩm.', $this->service->getAll());
    }

    public function store(StoreProductRequest $request)
    {
        return $this->responseCommon(201, 'Thêm mới sản phẩm thành công.', $this->service->create($request));
    }

    public function show(int $id)
    {
        return $this->responseCommon(201, 'Tìm thành công sản phẩm.', $this->service->show($id));
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        return $this->responseCommon(200, 'Cập nhật sản phẩm thành công.', $this->service->update($request, $id));
    }

    public function destroy(int $id)
    {
        return $this->responseCommon(200, 'Xóa sản phẩm thành công.', $this->service->delete($id));
    }
}
