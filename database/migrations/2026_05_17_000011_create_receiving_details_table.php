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
        Schema::create('receiving_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_receiving_id')->constrained('stock_receivings')->onDelete('cascade');
            $table->string('product_code');
            $table->string('product_name');
            $table->integer('quantity_ordered');
            $table->integer('quantity_received');
            $table->string('batch_number')->nullable();
            $table->timestamp('expiry_date')->nullable();
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->enum('status', ['pending', 'received', 'discrepancy'])->default('pending');
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
        Schema::dropIfExists('receiving_details');
    }
};
