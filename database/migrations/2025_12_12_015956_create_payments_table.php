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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // PROFORMA RELATION
            $table->foreignId('proforma_id')
                ->constrained('proformas')
                ->onDelete('cascade');

            // CASHIER (PROFILE)
            $table->foreignId('cashier_id')
                ->nullable()
                ->constrained('profiles')
                ->onDelete('set null');

            // PAYMENT DATA
            $table->decimal('amount', 10, 2); // valor pagado
            $table->string('payment_method'); // cash, transfer, card, etc
            $table->dateTime('paid_at')->nullable(); // fecha del pago

            // OPTIONAL DOCUMENT (PDF or image)
            $table->string('receipt_path')->nullable();

            // NOTES
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
