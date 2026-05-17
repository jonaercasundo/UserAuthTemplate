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
        Schema::create('stock_releases', function (Blueprint $table) {
            $table->id();
            $table->string('release_code')->unique();
            $table->enum('release_type', ['customer-order', 'internal-use', 'return', 'disposal'])->default('customer-order');
            $table->string('reference_number')->nullable();
            $table->foreignId('released_by')->constrained('users');
            $table->timestamp('release_date');
            $table->integer('total_items')->default(0);
            $table->integer('total_quantity')->default(0);
            $table->enum('status', ['pending', 'released', 'completed'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('release_code');
            $table->index('status');
            $table->index('release_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_releases');
    }
};
