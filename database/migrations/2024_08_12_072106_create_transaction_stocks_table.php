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
        Schema::create('transaction_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('item_id');
            $table->integer('in');
            $table->integer('out');
            $table->date('transaction_date');
            $table->integer('department_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_stocks');
    }
};