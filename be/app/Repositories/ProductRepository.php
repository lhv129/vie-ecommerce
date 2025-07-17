<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{

    public function getAll()
    {
        return Product::get();
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(int $id, array $data)
    {
        return Product::where('id', $id)->update($data);
    }

    public function findById(int $id)
    {
        return Product::where('id', $id)->first();
    }

    public function delete(int $id)
    {
        $product = $this->findById($id);
        $product->delete();
        return [];
    }
}
