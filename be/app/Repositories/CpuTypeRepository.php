<?php
namespace App\Repositories;

use App\Models\CpuType;

class CpuTypeRepository{
    
    public function all()
    {
        return CpuType::select('id', 'name','family','slug')->get();
    }

    public function create(array $data)
    {
        return CpuType::create($data);
    }

    public function update(int $id, array $data)
    {
        return CpuType::where('id', $id)->update($data);
    }

    public function findById(int $id)
    {
        return CpuType::where('id', $id)->first();
    }

    public function delete(int $id)
    {
        $cpuType = $this->findById($id);
        $cpuType->delete();
        return [];
    }
}