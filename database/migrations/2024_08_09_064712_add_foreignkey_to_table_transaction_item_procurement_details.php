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
        Schema::table('transaction_item_procurement_details', function (Blueprint $table) {
            $table->foreign('header_id')->references('id')->on('transaction_item_procurement_headers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_item_procurement_details', function (Blueprint $table) {
            //
        });
    }
};
