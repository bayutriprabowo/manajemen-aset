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
        Schema::table('master_departments', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('master_companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_departments', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
        });
    }
};
