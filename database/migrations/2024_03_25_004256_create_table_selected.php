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
        Schema::create('selected_shipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(table:'users', indexName:'fk_user_selected_id');
            $table->foreignId('shipment_id')->constrained(table:'shipped_item', indexName:'bla_bla_bla');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_selected');
    }
};
