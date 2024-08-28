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
        Schema::table('transaction_monitoring_forms', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('master_items')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('master_departments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('transaction_monitoring_logs', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('master_items')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('master_departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_monitoring_forms', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
            $table->dropForeign(['department_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::table('transaction_monitoring_logs', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
            $table->dropForeign(['department_id']);
        });
    }
};
