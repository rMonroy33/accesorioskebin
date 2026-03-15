<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('subcategory_id')
                ->nullable()
                ->constrained('subcategories')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('name', 180);
            $table->string('slug', 200)->unique();
            $table->string('sku', 80)->unique();

            $table->string('short_description', 255)->nullable();
            $table->text('description')->nullable();

            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();

            $table->integer('stock')->default(0);
            $table->integer('min_stock')->default(0);

            $table->string('main_image')->nullable();

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_on_sale')->default(false);
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};