<?php
namespace App\Services;

use Illuminate\Support\Str;
use App\Helpers\StringHelper;
use App\Http\Requests\StoreCpuTypeRequest;
use App\Http\Requests\UpdateCpuTypeRequest;
use App\Repositories\CpuTypeRepository;

class CpuTypeService{
    protected $repo;
    public function __construct(CpuTypeRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll()
    {
        return $this->repo->all();
    }

    public function create(StoreCpuTypeRequest $request)
    {
        $data = $request->validated();
        // Tự động xử lý viết hoa chữ cái đầu tiên
        $data['name'] = StringHelper::mbUcFirst($data['name']);
        // Tự động thêm slug theo name
        $data['slug'] = Str::slug($data['name']);
        // Trả về thông tin danh mục đã thêm mới
        return $this->repo->create($data);
    }

    public function show($id){
        return $this->repo->findById($id);
    }

    public function update(UpdateCpuTypeRequest $request, int $id)
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
        $cpuType = $this->repo->findById($id);
        if (!$cpuType) {
            return null;
        }
        $this->repo->delete($id);
        return $cpuType;
    }

}