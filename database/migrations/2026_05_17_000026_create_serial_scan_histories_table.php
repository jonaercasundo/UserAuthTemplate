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
        Schema::create('serial_scan_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('serial_number_tracking_id')->constrained('serial_number_trackings')->onDelete('cascade');
            $table->string('scan_code')->unique();
            $table->enum('scan_type', ['receiving', 'release', 'transfer', 'tracking', 'verification'])->default('receiving');
            $table->foreignId('scanned_by')->constrained('users');
            $table->timestamp('scan_date');
            $table->string('scan_location')->nullable();
            $table->string('reference_code')->nullable();
            $table->enum('status', ['success', 'error'])->default('success');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('scan_date');
            $table->index('scan_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serial_scan_histories');
    }
};
