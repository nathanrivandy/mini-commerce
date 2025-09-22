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
        Schema::create('item_keranjang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keranjang_id')->constrained()->onDelete('cascade');
            $table->foreignId('keranjang_id')->constrained()->onDelete('cascade');
            $table->integer('qty')->default(1);
            $table->timestamps();

            $table->unique(['Keranjang_id', 'product_id']); // One product per Keranjang
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_keranjang');
    }
};