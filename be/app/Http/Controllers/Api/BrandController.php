<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\BrandService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;

class BrandController extends Controller
{
    protected $service;
    public function __construct(BrandService $service)
    {
        $this->service = $service;
    }

    public function index(){
        return $this->responseCommon(200, 'Lấy danh sách thương hiệu thành công', $this->service->getAll());
    }

    public function store(StoreBrandRequest $request)
    {
        return $this->responseCommon(201, 'Thêm mới thành công thương hiệu', $this->service->create($request));
    }

    public function show(int $id)
    {
        return $this->responseCommon(201, 'Tìm thành công thương hiệu', $this->service->show($id));
    }

    public function update(UpdateBrandRequest $request, int $id)
    {
        return $this->responseCommon(200, 'Cập nhật thương hiệu thành công', $this->service->update($request, $id));
    }

    public function destroy(int $id)
    {
        $brand = $this->service->delete($id);
        if (!$brand) {
            return $this->responseCommon(200, 'Thương hiệu không tồn tại, vui lòng kiểm tra lại', []);
        } else {
            return $this->responseCommon(200, 'Xóa thương hiệu thành công', []);
        }
    }
}
