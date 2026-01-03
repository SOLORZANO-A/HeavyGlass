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
        Schema::create('intake_photos', function (Blueprint $table) {
            $table->id();

            // FK hacia la hoja de ingreso
            $table->foreignId('intake_sheet_id')
                ->constrained('intake_sheets')
                ->onDelete('cascade');

            $table->string('path');            // Ruta de la imagen
            $table->string('type')->nullable(); // general, damage, signature
            $table->text('description')->nullable(); // info opcional

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intake_photos');
    }
};
