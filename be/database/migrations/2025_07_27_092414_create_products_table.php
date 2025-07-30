<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_category_id');
            $table->unsignedBigInteger('brand_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->string('variant_name')->nullable();
            $table->boolean('is_new')->default(false); // Sản phẩm mới
            $table->boolean('is_on_sale')->default(false); // Có chương trình giảm giá
            $table->integer('stock_quantity')->default(0); // Số lượng tồn kho
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
