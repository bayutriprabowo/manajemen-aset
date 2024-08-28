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
            $table->integer('department_id');
            $table->integer('quantity');
        });

        Schema::table('transaction_monitoring_logs', function (Blueprint $table) {
            $table->integer('department_id');
            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_monitoring_forms', function (Blueprint $table) {
            $table->dropColumn('department_id');
            $table->dropColumn('quantity');
        });
        Schema::table('transaction_monitoring_logs', function (Blueprint $table) {
            $table->dropColumn('department_id');
            $table->dropColumn('quantity');
        });
    }
};
