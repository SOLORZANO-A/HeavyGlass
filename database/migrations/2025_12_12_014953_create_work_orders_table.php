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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();

            // Optional relationship to intake sheet
            $table->foreignId('intake_sheet_id')
                ->nullable()
                ->constrained('intake_sheets')
                ->onDelete('set null');

            // Required: Every work order belongs to a vehicle
            $table->foreignId('vehicle_id')
                ->constrained('vehicles')
                ->onDelete('cascade');

            // The job type (painting, bodywork, etc.)
            $table->foreignId('work_type_id')
                ->constrained('work_types')
                ->onDelete('restrict');

            // Technician (Profile, not User)
            $table->foreignId('technician_id')
                ->nullable()
                ->constrained('profiles')
                ->onDelete('set null');

            // Status of the job
            $table->enum('status', [
                'pending',
                'in_progress',
                'paused',
                'completed'
            ])->default('pending');

            // Dates
            $table->dateTime('assigned_at')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('finished_at')->nullable();

            // Notes
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
