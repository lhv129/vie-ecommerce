<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantSpec;
use App\Models\CpuType;
use App\Models\RamType;
use App\Models\StorageType;
use App\Models\OsType;
use App\Models\ScreenType;
use App\Models\SpecGroup;
use App\Models\SpecItem;

class LaptopProductSeeder extends Seeder
{
    public function run()
    {
        // Tạo nhóm thông số cho Laptop
        $specGroup = SpecGroup::firstOrCreate([
            'name' => 'Laptop Specs',
            'category_id' => 4 // Laptop
        ]);

        // Tạo các spec items
        $cpu = SpecItem::firstOrCreate(['label' => 'CPU', 'group_id' => $specGroup->id], ['unit' => '', 'data_type' => 'text']);
        $ram = SpecItem::firstOrCreate(['label' => 'RAM', 'group_id' => $specGroup->id], ['unit' => 'GB', 'data_type' => 'text']);
        $storage = SpecItem::firstOrCreate(['label' => 'Storage', 'group_id' => $specGroup->id], ['unit' => 'GB', 'data_type' => 'text']);
        $os = SpecItem::firstOrCreate(['label' => 'OS', 'group_id' => $specGroup->id], ['unit' => '', 'data_type' => 'text']);
        $screen = SpecItem::firstOrCreate(['label' => 'Screen', 'group_id' => $specGroup->id], ['unit' => 'inch', 'data_type' => 'text']);

        // Dữ liệu cấu hình
        $cpuType = CpuType::create([
            'name' => 'Intel Core i7-1335U',
            'family' => 'i7',
            'slug' => Str::slug('Intel Core i7-1335U')
        ]);

        $ram8 = RamType::create(['name' => '8GB LPDDR5X', 'slug' => Str::slug('8GB LPDDR5X')]);
        $ram16 = RamType::create(['name' => '16GB LPDDR5X', 'slug' => Str::slug('16GB LPDDR5X')]);

        $ssd256 = StorageType::create(['name' => '256GB SSD Gen4', 'slug' => Str::slug('256GB SSD Gen4')]);
        $ssd512 = StorageType::create(['name' => '512GB SSD Gen4', 'slug' => Str::slug('512GB SSD Gen4')]);

        $windows = OsType::create(['name' => 'Windows 11 Home', 'slug' => Str::slug('Windows 11 Home')]);
        $screenSpec = ScreenType::create(['name' => '15.6 inch OLED FullHD', 'slug' => Str::slug('15.6 inch OLED FullHD')]);

        // Tạo sản phẩm ASUS Vivobook
        $product = Product::create([
            'name' => 'ASUS Vivobook 15',
            'description' => 'Laptop văn phòng mỏng nhẹ, hiệu năng tốt',
            'category_id' => 4,
            'sub_category_id' => 2,
            'brand_id' => 1,
            'slug' => 'ASUS-Vivobook-15',
        ]);

        // Tạo biến thể 1
        $variant1 = ProductVariant::create([
            'product_id' => $product->id,
            'sku' => 'ASUS-VB15-I7-8GB-256',
            'price' => 16990000,
            'original_price' => 18990000,
            'discount_rate' => 10,
            'stock_quantity' => 12,
            'status' => 'active'
        ]);

        // Tạo biến thể 2
        $variant2 = ProductVariant::create([
            'product_id' => $product->id,
            'sku' => 'ASUS-VB15-I7-16GB-512',
            'price' => 19490000,
            'original_price' => 21490000,
            'discount_rate' => 9,
            'stock_quantity' => 8,
            'status' => 'active'
        ]);

        // Specs cho từng biến thể
        foreach (
            [
                $variant1->id => [
                    $cpu->id => $cpuType->name,
                    $ram->id => $ram8->name,
                    $storage->id => $ssd256->name,
                    $os->id => $windows->name,
                    $screen->id => $screenSpec->name
                ],
                $variant2->id => [
                    $cpu->id => $cpuType->name,
                    $ram->id => $ram16->name,
                    $storage->id => $ssd512->name,
                    $os->id => $windows->name,
                    $screen->id => $screenSpec->name
                ]
            ] as $variantId => $specs
        ) {
            foreach ($specs as $specItemId => $value) {
                ProductVariantSpec::create([
                    'product_variant_id' => $variantId,
                    'spec_item_id' => $specItemId,
                    'value' => $value
                ]);
            }
        }
    }
}
