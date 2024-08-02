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
        Schema::table('master_items', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('master_companies')->onDelete('cascade'); // Menetapkan foreign key
            $table->foreign('department_id')->references('id')->on('master_departments')->onDelete('cascade'); // Menetapkan foreign key
            $table->foreign('section_id')->references('id')->on('master_sections')->onDelete('cascade'); // Menetapkan foreign key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_items', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropForeign(['department_id']);
            $table->dropForeign(['section_id']);
        });
    }
};
