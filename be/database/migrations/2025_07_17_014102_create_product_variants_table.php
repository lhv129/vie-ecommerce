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
            $table->unsignedBigInteger('product_id');
            $table->string('sku')->nullable();
            $table->decimal('price', 12, 2);
            $table->decimal('original_price', 12, 2)->nullable();
            $table->float('discount_rate')->nullable();
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->unsignedBigInteger('storage_capacity_id')->nullable();
            $table->unsignedBigInteger('screen_size_id')->nullable();
            $table->unsignedBigInteger('color_type_id')->nullable();
            $table->unsignedBigInteger('ram_type_id')->nullable();
            $table->unsignedBigInteger('cpu_type_id')->nullable();
            $table->enum('status', ['active', 'inactive', 'coming_soon'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('storage_capacity_id')->references('id')->on('storage_types')->nullOnDelete();
            $table->foreign('screen_size_id')->references('id')->on('screen_types')->nullOnDelete();
            $table->foreign('color_type_id')->references('id')->on('color_types')->nullOnDelete();
            $table->foreign('ram_type_id')->references('id')->on('ram_types')->nullOnDelete();
            $table->foreign('cpu_type_id')->references('id')->on('cpu_types')->nullOnDelete();
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
