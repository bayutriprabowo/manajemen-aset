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
        Schema::create('transaction_item_procurement_headers', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date');
            $table->enum('status', ['in_progress', 'approved', 'rejected']);
            $table->string('code');
            $table->text('description');
            $table->float('total', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_item_procurement_headers');
    }
};
