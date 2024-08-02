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
        Schema::create('master_sections', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->string('section_number');
            $table->string('contact_person');
            $table->string('contact_person_number');
            $table->integer('company_id');
            $table->integer('department_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_sections');
    }
};
