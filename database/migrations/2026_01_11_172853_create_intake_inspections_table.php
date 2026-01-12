<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('intake_inspections', function (Blueprint $table) {

            $table->id();

            $table->foreignId('intake_sheet_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('created_by')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null'); // 👈 compatible con MySQL viejo

            $table->json('observations')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('intake_inspections');
    }
};
