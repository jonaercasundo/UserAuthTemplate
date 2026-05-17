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
        Schema::create('inventory_alerts', function (Blueprint $table) {
            $table->id();
            $table->string('alert_code')->unique();
            $table->string('product_code');
            $table->string('product_name');
            $table->enum('alert_type', ['low-stock', 'out-of-stock', 'overstock']);
            $table->integer('current_quantity');
            $table->integer('threshold_quantity');
            $table->timestamp('alert_date');
            $table->enum('status', ['active', 'acknowledged', 'resolved'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('product_code');
            $table->index('status');
            $table->index('alert_type');
            $table->index('alert_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_alerts');
    }
};
