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
        Schema::create('q_r_code_scans', function (Blueprint $table) {
            $table->id();
            $table->string('scan_code')->unique();
            $table->string('qr_code');
            $table->string('product_code');
            $table->string('product_name');
            $table->string('batch_number')->nullable();
            $table->string('serial_number')->nullable();
            $table->foreignId('scanned_by')->constrained('users');
            $table->timestamp('scan_date');
            $table->string('scan_location')->nullable();
            $table->enum('scan_type', ['receiving', 'release', 'transfer', 'verification', 'tracking'])->default('receiving');
            $table->string('reference_code')->nullable();
            $table->integer('quantity')->default(1);
            $table->enum('status', ['success', 'error', 'invalid', 'duplicate'])->default('success');
            $table->text('error_message')->nullable();
            $table->timestamps();
            
            $table->index('qr_code');
            $table->index('product_code');
            $table->index('serial_number');
            $table->index('scan_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('q_r_code_scans');
    }
};
