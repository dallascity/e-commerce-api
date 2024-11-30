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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Kullanıcı ile ilişki
            $table->decimal('total_amount', 10, 2); // Toplam tutar
            $table->string('status')->default('pending'); // 'pending', 'completed', 'cancelled'
            $table->timestamps();
            $table->softDeletes(); // deleted_at sütunu
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
