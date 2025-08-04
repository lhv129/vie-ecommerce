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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->text('features');
            $table->string('image')->nullable();
            $table->string('fileImage')->nullable();
            $table->boolean('is_new')->default(false); // Sản phẩm mới
            $table->boolean('is_on_sale')->default(false); // Có chương trình giảm giá
            $table->integer('stock_quantity')->default(0); // Số lượng tồn kho
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
