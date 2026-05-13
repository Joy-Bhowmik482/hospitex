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
        Schema::create('maintenance_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained()->onDelete('cascade');
            $table->string('maintenance_type'); // preventive, corrective, calibration, etc.
            $table->enum('priority', ['critical', 'high', 'medium', 'low'])->default('medium');
            $table->dateTime('scheduled_date');
            $table->dateTime('scheduled_end_date')->nullable();
            $table->string('technician_name')->nullable();
            $table->string('technician_contact')->nullable();
            $table->string('department')->nullable();
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'overdue', 'cancelled'])->default('scheduled');
            $table->decimal('estimated_cost', 10, 2)->nullable();
            $table->decimal('actual_cost', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->text('work_performed')->nullable();
            $table->text('parts_used')->nullable();
            $table->text('notes')->nullable();
            $table->dateTime('completed_date')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_schedules');
    }
};
