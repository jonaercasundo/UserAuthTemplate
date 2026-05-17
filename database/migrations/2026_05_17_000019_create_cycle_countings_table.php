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
        Schema::create('cycle_countings', function (Blueprint $table) {
            $table->id();
            $table->string('count_code')->unique();
            $table->string('warehouse_id')->nullable();
            $table->timestamp('count_date');
            $table->foreignId('counted_by')->constrained('users');
            $table->integer('total_items_counted')->default(0);
            $table->integer('discrepancies')->default(0);
            $table->enum('status', ['pending', 'in-progress', 'completed', 'reconciled'])->default('pending');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('count_code');
            $table->index('status');
            $table->index('count_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cycle_countings');
    }
};
