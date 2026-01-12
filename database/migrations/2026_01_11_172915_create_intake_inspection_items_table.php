<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('intake_inspection_items', function (Blueprint $table) {

            $table->id();

            $table->foreignId('intake_inspection_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('inspection_zone_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('inspection_part_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->boolean('change')->default(false);
            $table->boolean('paint')->default(false);
            $table->boolean('fiber')->default(false);
            $table->boolean('dent')->default(false);
            $table->boolean('crack')->default(false);

            $table->text('notes')->nullable();

            // 🔑 ÍNDICE ÚNICO CON NOMBRE CORTO (OBLIGATORIO EN MYSQL)
            $table->unique(
                ['intake_inspection_id', 'inspection_zone_id', 'inspection_part_id'],
                'uniq_inspection_zone_part'
            );

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('intake_inspection_items');
    }
};
