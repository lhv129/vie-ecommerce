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
        Schema::create('spec_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->string('label');
            $table->string('unit')->nullable();
            $table->string('data_type')->default('text');
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('spec_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spec_items');
    }
};
