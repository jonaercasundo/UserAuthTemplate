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
        Schema::create('pull_out_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_pull_out_id')->constrained('item_pull_outs')->onDelete('cascade');
            $table->string('product_code');
            $table->string('product_name');
            $table->integer('quantity_pulled');
            $table->string('batch_number')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('reason_detail')->nullable();
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
        Schema::dropIfExists('pull_out_details');
    }
};
