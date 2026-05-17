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
        Schema::create('damaged_items', function (Blueprint $table) {
            $table->id();
            $table->string('report_code')->unique();
            $table->string('product_code');
            $table->string('product_name');
            $table->integer('quantity_damaged');
            $table->string('damage_type');
            $table->foreignId('reported_by')->constrained('users');
            $table->timestamp('reported_date');
            $table->text('description')->nullable();
            $table->enum('status', ['reported', 'under-review', 'resolved'])->default('reported');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('product_code');
            $table->index('status');
            $table->index('reported_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damaged_items');
    }
};
