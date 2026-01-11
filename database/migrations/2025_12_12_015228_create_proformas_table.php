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
        Schema::create('proformas', function (Blueprint $table) {
            $table->id();

            // Link to intake sheet (optional but highly recommended)
            $table->foreignId('intake_sheet_id')
                ->nullable()
                ->constrained('intake_sheets')
                ->onDelete('set null');

            // Proforma reference number
            $table->string('number')->unique()->nullable();

            // CLIENT SNAPSHOT (data stored at the moment of proforma creation)
            $table->string('client_name');
            $table->string('client_document')->nullable();
            $table->string('client_phone')->nullable();
            $table->string('client_email')->nullable();

            // VEHICLE SNAPSHOT
            $table->string('vehicle_brand')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('vehicle_plate')->nullable();

            // FINANCIAL FIELDS
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            // STATUS
            $table->enum('status', [
                'pending',
                'partial',
                'paid',
                'approved',
                'cancelled'
            ])->default('pending');

            // Additional notes
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proformas');
    }
};
