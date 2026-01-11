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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            // Relationship with user (nullable for technicians)
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            // Basic personal info
            $table->string('first_name');
            $table->string('last_name');
            $table->string('document')->nullable(); // cedula, ID
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            // Type of staff (system roles or technicians)
            $table->enum('staff_type', [
                'admin',
                'advisor',
                'workshop_boss',
                'cashier',
                'technician'
            ])->default('technician');

            // Technician specialization (optional)
            $table->string('specialization')->nullable(); // Painting, bodywork, etc.

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
        Schema::dropIfExists('profiles');
    }
};
