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
        Schema::create('item_pull_outs', function (Blueprint $table) {
            $table->id();
            $table->string('pullout_code')->unique();
            $table->enum('pullout_type', ['stock-shortage', 'damaged-stock', 'expired', 'return'])->default('stock-shortage');
            $table->string('warehouse_id')->nullable();
            $table->foreignId('pulled_out_by')->constrained('users');
            $table->timestamp('pullout_date');
            $table->integer('total_quantity')->default(0);
            $table->string('reason')->nullable();
            $table->enum('status', ['pending', 'completed'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('pullout_code');
            $table->index('status');
            $table->index('pullout_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_pull_outs');
    }
};
