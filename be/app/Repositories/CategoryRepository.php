<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function all()
    {
        return Category::select('id', 'name', 'slug')->get();
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update(int $id, array $data)
    {
        return Category::where('id', $id)->update($data);
    }

    public function findById(int $id)
    {
        return Category::where('id', $id)->first();
    }

    public function delete(int $id)
    {
        $category = $this->findById($id);
        $category->delete();
        return [];
    }
}
