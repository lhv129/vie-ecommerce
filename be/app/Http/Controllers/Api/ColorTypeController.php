<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreColorTypeRequest;
use App\Http\Requests\UpdateColorTypeRequest;
use App\Services\ColorTypeService;
use Illuminate\Http\Request;

class ColorTypeController extends Controller
{
    protected $service;
    public function __construct(ColorTypeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->responseCommon(200, 'Lấy thành công danh sách màu sắc sản phẩm', $this->service->getAll());
    }

    public function store(StoreColorTypeRequest $request)
    {
        return $this->responseCommon(201, 'Thêm mới thành công màu sắc sản phẩm', $this->service->create($request));
    }

    public function show(int $id)
    {
        return $this->responseCommon(201, 'Tìm thành công màu sắc', $this->service->show($id));
    }

    public function update(UpdateColorTypeRequest $request, int $id)
    {
        return $this->responseCommon(200, 'Cập nhật thành công màu sắc sản phẩm', $this->service->update($request, $id));
    }

    public function destroy(int $id)
    {
        $colorType = $this->service->delete($id);
        if (!$colorType) {
            return $this->responseCommon(200, 'Màu sắc sản phẩm không tồn tại, vui lòng kiểm tra lại', []);
        } else {
            return $this->responseCommon(200, 'Xóa màu sắc sản phẩm thành công', []);
        }
    }
}
