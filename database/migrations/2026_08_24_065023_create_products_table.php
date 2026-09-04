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

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();

            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->text('des');
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0)->nullable();
            $table->string('image')->nullable();
            $table->decimal('quantity', 10, 0)->nullable();
            $table->decimal('discount_price', 8, 0)->nullable();
            $table->boolean('is_best_seller')->default(false)->nullable();
            $table->boolean('is_featured')->default(false)->nullable();
            $table->string('brand')->nullable();
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
