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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spec_group_id');
            $table->string('name'); // CPU, RAM, STORAGE...
            $table->boolean('is_required')->default(false);
            $table->unsignedInteger('display_order')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('spec_group_id')->references('id')->on('spec_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
