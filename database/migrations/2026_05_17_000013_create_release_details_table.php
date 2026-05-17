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
        Schema::create('release_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_release_id')->constrained('stock_releases')->onDelete('cascade');
            $table->string('product_code');
            $table->string('product_name');
            $table->integer('quantity_to_release');
            $table->integer('quantity_released')->default(0);
            $table->string('batch_number')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('status')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('product_code');
            $table->index('serial_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('release_details');
    }
};
