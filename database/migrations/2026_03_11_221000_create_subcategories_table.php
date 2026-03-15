<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('name', 120);
            $table->string('slug', 150);
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();

            $table->unique(['category_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subcategories');
    }
};