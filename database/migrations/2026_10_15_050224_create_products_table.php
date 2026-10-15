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
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('name');
            $table->string('scientific_name')->nullable();
            $table->string('sku')->unique();
            $table->decimal('price', 12, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->integer('min_stock')->default(5);
            $table->string('light_requirement')->nullable();
            $table->string('watering_schedule')->nullable();
            $table->text('image_url')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
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
