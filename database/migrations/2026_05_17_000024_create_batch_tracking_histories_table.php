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
        Schema::create('batch_tracking_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_tracking_id')->constrained('batch_trackings')->onDelete('cascade');
            $table->enum('action_type', ['received', 'released', 'transferred', 'adjusted'])->default('received');
            $table->integer('quantity_changed');
            $table->string('reference_code')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamp('action_date');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('batch_tracking_id');
            $table->index('action_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_tracking_histories');
    }
};
