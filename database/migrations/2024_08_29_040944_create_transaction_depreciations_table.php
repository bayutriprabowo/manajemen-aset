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
        Schema::create('transaction_depreciations', function (Blueprint $table) {
            $table->id();
            $table->date('procurement_date');
            $table->integer('item_id');
            $table->integer('department_id');
            $table->integer('user_id');
            $table->float('price');
            $table->integer('useful_life');
            $table->integer('residual_value');
            $table->float('depreciation_value', 15, 2);
            $table->timestamps();
        });

        Schema::table('transaction_depreciations', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('master_items')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('master_departments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('transaction_depreciations', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
            $table->dropForeign(['department_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('transaction_depreciations');
    }
};
