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
        Schema::create('transaction_item_movement_details', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id');
            $table->integer('stock');
            $table->integer('quantity');
            $table->integer('header_id');
            $table->timestamps();
        });

        Schema::table('transaction_item_movement_details', function (Blueprint $table) {
            // Menambahkan foreign key constraint
            $table->foreign('item_id')->references('id')->on('master_items')->onDelete('cascade');
            $table->foreign('header_id')->references('id')->on('transaction_item_movement_headers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_item_movement_details', function (Blueprint $table) {
            // Menghapus foreign key constraint
            $table->dropForeign(['item_id']);
            $table->dropForeign(['header_id']);
        });


        Schema::dropIfExists('transaction_item_movement_details');
    }
};
