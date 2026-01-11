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
        Schema::create('proforma_details', function (Blueprint $table) {
            $table->id();

            // FK → each detail belongs to a proforma
            $table->foreignId('proforma_id')
                ->constrained('proformas')
                ->onDelete('cascade');

            // Description of the item (work or spare part)
            $table->string('item_description');

            // Quantity of the item (can be 1 for labor)
            $table->integer('quantity')->default(1);

            // Unit price
            $table->decimal('unit_price', 10, 2)->default(0);

            // Total line: quantity * unit_price
            $table->decimal('line_total', 10, 2)->default(0);

            // Optional notes
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proforma_details');
    }
};
