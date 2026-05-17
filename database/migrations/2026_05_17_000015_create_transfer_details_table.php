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
        Schema::create('transfer_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_transfer_id')->constrained('warehouse_transfers')->onDelete('cascade');
            $table->string('product_code');
            $table->string('product_name');
            $table->integer('quantity_to_transfer');
            $table->integer('quantity_transferred')->default(0);
            $table->string('batch_number')->nullable();
            $table->string('status')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('product_code');
            $table->index('batch_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_details');
    }
};
