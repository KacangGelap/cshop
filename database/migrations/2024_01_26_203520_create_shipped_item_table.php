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
        Schema::create('shipped_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(
                table: 'users', indexName: 'ship_user_id'
            );
            $table->foreignId('item_id')->constrained(
                table: 'items', indexName: 'ship_item_id'
            );
            $table->integer('item_count');
            $table->integer('total_price');
            $table->timestamps();
            $table->enum('status',['menunggu penjual', 
            'diproses penjual', 
            'menunggu kurir', 
            'sedang dikirim', 
            'sampai di tujuan', 
            'diterima pembeli', 
            'dikomplain', 
            'dikirim balik', 
            'transaksi gagal']);
            $table->enum('payment_status',['True','False']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipped_item');
    }
};
