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
        Schema::create('warehouse_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_code')->unique();
            $table->string('from_warehouse');
            $table->string('to_warehouse');
            $table->timestamp('transfer_date');
            $table->foreignId('requested_by')->constrained('users');
            $table->foreignId('transferred_by')->nullable()->constrained('users');
            $table->integer('total_items')->default(0);
            $table->integer('total_quantity')->default(0);
            $table->enum('status', ['pending', 'in-transit', 'received', 'completed'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('transfer_code');
            $table->index('status');
            $table->index('from_warehouse');
            $table->index('to_warehouse');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_transfers');
    }
};
