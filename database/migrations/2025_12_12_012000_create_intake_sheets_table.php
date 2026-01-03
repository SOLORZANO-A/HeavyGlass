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
    Schema::create('intake_sheets', function (Blueprint $table) {
        $table->id();

        // Relación con vehículos
        $table->foreignId('vehicle_id')
            ->constrained('vehicles')
            ->cascadeOnDelete();

        // Asesor (usuario del sistema)
        $table->foreignId('advisor_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

        // Datos del ingreso
        $table->dateTime('entry_at')->nullable();
        $table->integer('km_at_entry')->nullable();
        $table->string('fuel_level')->nullable();

        // Estado general
        $table->boolean('has_dents')->default(false);
        $table->boolean('has_scratches')->default(false);
        $table->boolean('has_cracks')->default(false);

        // Observaciones
        $table->text('observations')->nullable();
        $table->text('valuables')->nullable();

        // Firma y fecha estimada
        $table->string('client_signature_path')->nullable();
        $table->date('estimated_delivery_date')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intake_sheets');
    }
};
