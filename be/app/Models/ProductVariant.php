<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['product_id', 'sku', 'price', 'original_price', 'discount_rate', 'stock_quantity', 'color_type_id', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function specs()
    {
        return $this->hasMany(ProductVariantSpec::class);
    }

}
