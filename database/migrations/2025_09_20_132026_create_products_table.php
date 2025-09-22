<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Relasi ke categories
            $table->foreignId('category_id')
                ->constrained()                    // ->references('id')->on('categories')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('name');
            $table->decimal('price', 12, 2);       // harga 2 desimal
            $table->unsignedInteger('stock')->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();

            $table->timestamps();

            // Nama produk unik per kategori
            $table->unique(['category_id', 'name']);

            // Index bantu untuk query umum
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
