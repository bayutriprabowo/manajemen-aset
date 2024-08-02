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
            $table->integer('company_id'); // Menambahkan kolom company_id, department_id, dan section_id
            $table->integer('department_id');
            $table->integer('section_id');
            $table->dropColumn('code'); // menghapus kolom code
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_items', function (Blueprint $table) {
            $table->dropColumn('company_id'); // Menambahkan kolom company_id, department_id, dan section_id
            $table->dropColumn('department_id');
            $table->dropColumn('section_id');
            $table->string('code');
        });
    }
};
