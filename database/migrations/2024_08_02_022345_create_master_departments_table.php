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
        Schema::create('master_departments', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->string('department_number');
            $table->string('contact_person');
            $table->string('contact_person_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_departments');
    }
};
