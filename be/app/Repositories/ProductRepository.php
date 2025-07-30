<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductImage;

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

    public function getOne(int $id)
    {
        return Product::with([
            'images' => function ($query) {
                // Luôn chọn khóa ngoại product_id để Laravel có thể ghép nối
                $query->select('id', 'product_id', 'image', 'fileImage');
            },
            'sub_category' => function ($query) {
                // Luôn chọn khóa ngoại của mối quan hệ ('id' của sub_category) để Laravel có thể ghép nối
                $query->select('id', 'name');
            },
            'brand' => function ($query) {
                // Luôn chọn khóa ngoại của mối quan hệ ('id' của brand)
                $query->select('id', 'name');
            }
        ])->where('id', $id)->firstOrFail();
    }

    public function findById(int $id)
    {
        return Product::findOrFail($id);
    }

    public function delete(int $id)
    {
        $product = $this->findById($id);
        $product->delete();
        return [];
    }

    public function deleteOldProductImages(int $id){
        ProductImage::where('product_id', $id)->forceDelete();
    }
}
