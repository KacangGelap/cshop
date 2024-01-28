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
        Schema::create('comment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(
                table: 'users', indexName: 'comment_user_id'
            );
            $table->foreignId('item_id')->constrained(
                table: 'items', indexName: 'comment_item_id'
            );
            $table->integer('rating');
            $table->string('comment');
            $table->binary('media1');
            $table->binary('media2');
            $table->binary('media3');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment');
    }
};
