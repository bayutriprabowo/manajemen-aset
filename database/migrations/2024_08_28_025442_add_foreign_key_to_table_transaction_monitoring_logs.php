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
        Schema::table('transaction_monitoring_logs', function (Blueprint $table) {
            $table->foreign('monitoring_id')->references('id')->on('transaction_monitoring_forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_monitoring_logs', function (Blueprint $table) {
            $table->dropForeign(['monitoring_id']);
        });
    }
};
