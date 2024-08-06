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
        Schema::table('master_vendor_items', function (Blueprint $table) {
            $table->foreign('vendor_id')->references('id')->on('master_vendors')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('master_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_vendor_items', function (Blueprint $table) {
            $table->dropForeign(['vendor_id']);
            $table->dropForeign(['item_id']);
        });
    }
};
