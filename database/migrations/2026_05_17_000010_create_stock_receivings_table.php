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
        Schema::create('stock_receivings', function (Blueprint $table) {
            $table->id();
            $table->string('receiving_code')->unique();
            $table->string('purchase_order_number')->nullable();
            $table->string('supplier_id')->nullable();
            $table->foreignId('received_by')->constrained('users');
            $table->timestamp('receiving_date');
            $table->integer('total_items')->default(0);
            $table->integer('total_quantity')->default(0);
            $table->enum('status', ['pending', 'in-progress', 'completed'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('receiving_code');
            $table->index('status');
            $table->index('receiving_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_receivings');
    }
};
