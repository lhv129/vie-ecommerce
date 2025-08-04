<?php

namespace App\Models;

use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'description', 'sub_category_id', 'brand_id', 'slug'];

    // Thêm thuộc tính $hidden để ẩn các trường này khi chuyển đổi thành JSON/array
    protected $hidden = [
        'sub_category_id',
        'brand_id',
        'deleted_at', // Nếu bạn muốn ẩn cả soft delete timestamp
        'created_at',   // Nếu không muốn hiển thị
        'updated_at',   // Nếu không muốn hiển thị
    ];

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}
