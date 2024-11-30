<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->onDelete('cascade'); // Sepet ile ilişki
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Ürün ile ilişki
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // Ürün fiyatı
            $table->timestamps();
            $table->softDeletes(); // deleted_at sütunu
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
