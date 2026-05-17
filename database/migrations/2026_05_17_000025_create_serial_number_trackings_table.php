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
        Schema::create('serial_number_trackings', function (Blueprint $table) {
            $table->id();
            $table->string('serial_code')->unique();
            $table->string('product_code');
            $table->string('product_name');
            $table->string('serial_number')->unique();
            $table->string('batch_number')->nullable();
            $table->timestamp('received_date');
            $table->enum('status', ['in-warehouse', 'released', 'transferred', 'damaged', 'lost'])->default('in-warehouse');
            $table->string('current_location')->nullable();
            $table->string('warehouse_location')->nullable();
            $table->timestamp('last_scanned_date')->nullable();
            $table->string('last_scanned_location')->nullable();
            $table->foreignId('owner_user_id')->nullable()->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('serial_code');
            $table->index('serial_number');
            $table->index('product_code');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serial_number_trackings');
    }
};
