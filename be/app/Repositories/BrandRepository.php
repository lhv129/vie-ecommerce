<?php

namespace App\Repositories;

use App\Models\Brand;

class BrandRepository
{

    public function getAll()
    {
        return Brand::all();
    }

    public function create(array $data)
    {
        return Brand::create($data);
    }

    public function update(int $id, array $data)
    {
        return Brand::where('id', $id)->update($data);
    }

    public function findById(int $id)
    {
        return Brand::findOrFail($id);
    }

    public function delete(int $id)
    {
        $brand = $this->findById($id);
        $brand->delete();
        return [];
    }
}
