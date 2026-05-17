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
        Schema::create('batch_trackings', function (Blueprint $table) {
            $table->id();
            $table->string('batch_code')->unique();
            $table->string('product_code');
            $table->string('product_name');
            $table->string('batch_number');
            $table->timestamp('manufacture_date')->nullable();
            $table->timestamp('expiry_date')->nullable();
            $table->integer('quantity_received');
            $table->integer('quantity_available')->default(0);
            $table->integer('quantity_used')->default(0);
            $table->string('received_from')->nullable();
            $table->string('warehouse_location')->nullable();
            $table->enum('status', ['active', 'expired', 'exhausted', 'recalled'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('batch_code');
            $table->index('batch_number');
            $table->index('product_code');
            $table->index('status');
            $table->index('expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_trackings');
    }
};
