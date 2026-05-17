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
        Schema::create('barcode_scans', function (Blueprint $table) {
            $table->id();
            $table->string('scan_code')->unique();
            $table->string('barcode');
            $table->string('product_code');
            $table->string('product_name');
            $table->foreignId('scanned_by')->constrained('users');
            $table->timestamp('scan_date');
            $table->string('scan_location')->nullable();
            $table->enum('scan_type', ['receiving', 'release', 'transfer', 'count', 'adjustment'])->default('receiving');
            $table->string('reference_code')->nullable();
            $table->integer('quantity')->default(1);
            $table->enum('status', ['success', 'error', 'duplicate'])->default('success');
            $table->text('error_message')->nullable();
            $table->timestamps();
            
            $table->index('barcode');
            $table->index('product_code');
            $table->index('scan_date');
            $table->index('reference_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barcode_scans');
    }
};
