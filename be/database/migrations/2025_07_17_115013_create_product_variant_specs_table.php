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
        Schema::create('product_variant_specs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_variant_id');
            $table->unsignedBigInteger('spec_item_id');
            $table->text('value');                        
            $table->timestamps();

            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('cascade');
            $table->foreign('spec_item_id')->references('id')->on('spec_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variant_specs');
    }
};
