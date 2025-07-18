<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCpuTypeRequest;
use App\Http\Requests\UpdateCpuTypeRequest;
use App\Services\CpuTypeService;

class CpuTypeController extends Controller
{
    protected $service;
    public function __construct(CpuTypeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->responseCommon(200, 'Lấy thành công danh sách CPU', $this->service->getAll());
    }

    public function store(StoreCpuTypeRequest $request)
    {
        return $this->responseCommon(201, 'Thêm mới thành công CPU', $this->service->create($request));
    }

    public function show(int $id)
    {
        return $this->responseCommon(201, 'Tìm thành công CPU', $this->service->show($id));
    }

    public function update(UpdateCpuTypeRequest $request, int $id)
    {
        return $this->responseCommon(200, 'Cập nhật thành công CPU', $this->service->update($request, $id));
    }

    public function destroy(int $id)
    {
        $cpuType = $this->service->delete($id);
        if (!$cpuType) {
            return $this->responseCommon(200, 'CPU không tồn tại, vui lòng kiểm tra lại', []);
        } else {
            return $this->responseCommon(200, 'Xóa CPU thành công', []);
        }
    }
}
