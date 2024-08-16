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
        Schema::create('transaction_outgoing_items', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('user_id');
            $table->integer('item_id');
            $table->integer('department_id');
            $table->integer('quantity');
            $table->date('transaction_date');
            $table->integer('status_id');
            $table->text('description');
            $table->string('purpose');
            $table->timestamps();
        });

        Schema::table('transaction_outgoing_items', function (Blueprint $table) {
            // Drop foreign key berdasarkan nama kolom
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('master_items')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('master_departments')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('master_item_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('transaction_outgoing_items', function (Blueprint $table) {
            // Drop foreign key berdasarkan nama kolom
            $table->dropForeign(['user_id']);
            $table->dropForeign(['item_id']);
            $table->dropForeign(['department_id']);
            $table->dropForeign(['status_id']);
        });
        Schema::dropIfExists('transaction_outgoing_items');
    }
};
