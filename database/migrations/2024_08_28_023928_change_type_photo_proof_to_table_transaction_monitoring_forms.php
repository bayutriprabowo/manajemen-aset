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
            $table->string('photo_proof')->change();
        });

        Schema::table('transaction_monitoring_logs', function (Blueprint $table) {
            $table->string('photo_proof')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_monitoring_forms', function (Blueprint $table) {
            $table->binary('photo_proof')->change();
        });

        Schema::table('transaction_monitoring_logs', function (Blueprint $table) {
            $table->binary('photo_proof')->change();
        });
    }
};
