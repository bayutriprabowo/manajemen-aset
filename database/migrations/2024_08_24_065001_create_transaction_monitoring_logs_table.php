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
        Schema::create('transaction_monitoring_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id');
            $table->integer('monitoring_id');
            $table->date('transaction_date');
            $table->string('description');
            $table->float('cost', 15, 2);
            $table->binary('photo_proof')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_monitoring_logs');
    }
};
