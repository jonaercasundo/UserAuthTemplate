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
        Schema::create('count_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cycle_counting_id')->constrained('cycle_countings')->onDelete('cascade');
            $table->string('product_code');
            $table->string('product_name');
            $table->integer('system_quantity');
            $table->integer('counted_quantity');
            $table->integer('variance')->nullable();
            $table->decimal('variance_percentage', 5, 2)->nullable();
            $table->string('batch_number')->nullable();
            $table->enum('status', ['pending', 'counted', 'verified', 'discrepancy'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('product_code');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('count_details');
    }
};
