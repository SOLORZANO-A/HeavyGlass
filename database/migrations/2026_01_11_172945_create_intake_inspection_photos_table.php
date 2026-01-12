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
        Schema::create('intake_inspection_photos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('intake_inspection_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('inspection_zone_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intake_inspection_photos');
    }
};
