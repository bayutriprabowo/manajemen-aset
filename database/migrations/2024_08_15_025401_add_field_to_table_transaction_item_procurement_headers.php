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
        Schema::table('transaction_item_procurement_headers', function (Blueprint $table) {
            $table->integer('vendor_id');
            $table->integer('user_id');
            $table->foreign('vendor_id')->references('id')->on('master_vendors')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_item_procurement_headers', function (Blueprint $table) {
            $table->dropColumn('vendor_id');
            $table->dropColumn('user_id');
            $table->dropForeign(['vendor_id']);
            $table->dropForeign(['user_id']);
        });
    }
};
