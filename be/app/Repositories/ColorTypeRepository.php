<?php
namespace App\Repositories;

use App\Models\ColorType;

class ColorTypeRepository{
    
    public function all()
    {
        return ColorType::select('id', 'name', 'slug')->get();
    }

    public function create(array $data)
    {
        return ColorType::create($data);
    }

    public function update(int $id, array $data)
    {
        return ColorType::where('id', $id)->update($data);
    }

    public function findById(int $id)
    {
        return ColorType::where('id', $id)->first();
    }

    public function delete(int $id)
    {
        $colorType = $this->findById($id);
        $colorType->delete();
        return [];
    }
}