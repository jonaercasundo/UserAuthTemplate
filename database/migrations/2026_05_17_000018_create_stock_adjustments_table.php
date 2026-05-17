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
        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->id();
            $table->string('adjustment_code')->unique();
            $table->enum('adjustment_type', ['increase', 'decrease'])->default('decrease');
            $table->string('product_code');
            $table->string('product_name');
            $table->integer('quantity_before');
            $table->integer('quantity_after');
            $table->integer('adjustment_quantity');
            $table->string('reason')->nullable();
            $table->foreignId('adjusted_by')->constrained('users');
            $table->timestamp('adjustment_date');
            $table->enum('status', ['pending', 'approved', 'completed'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('adjustment_code');
            $table->index('product_code');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_adjustments');
    }
};
