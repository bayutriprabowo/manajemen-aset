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
        Schema::create('transaction_item_movement_headers', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('user_id');
            $table->integer('department_id_from');
            $table->integer('department_id_to');
            $table->date('transaction_date');
            $table->enum('status', ['in_progress', 'approved', 'rejected'])->default('in_progress');
            $table->string('purpose')->nullable();
            $table->integer('status_id');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::table('transaction_item_movement_headers', function (Blueprint $table) {
            // Menambahkan foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('department_id_from')->references('id')->on('master_departments')->onDelete('cascade');
            $table->foreign('department_id_to')->references('id')->on('master_departments')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('master_item_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_item_movement_headers', function (Blueprint $table) {
            // Menghapus foreign key constraint
            $table->dropForeign(['user_id']);
            $table->dropForeign(['department_id_from']);
            $table->dropForeign(['department_id_to']);
            $table->dropForeign(['status_id']);
        });


        Schema::dropIfExists('transaction_item_movement_headers');
    }
};
