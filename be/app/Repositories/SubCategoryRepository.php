<?php

namespace App\Repositories;

use App\Models\SubCategory;


class SubCategoryRepository
{
    public function getAll(int $categoryId)
    {
        return SubCategory::where('category_id', $categoryId)->get();
    }

    public function create(array $data)
    {
        return SubCategory::create($data);
    }

    public function update(int $id, array $data)
    {
        return SubCategory::where('id', $id)->update($data);
    }

    public function findById(int $id)
    {
        return SubCategory::findOrFail($id);
    }

    public function delete(int $id)
    {
        $subCategory = $this->findById($id);
        $subCategory->delete();
        return [];
    }
}
