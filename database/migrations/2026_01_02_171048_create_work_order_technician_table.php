<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('work_order_technician', function (Blueprint $table) {
            $table->id();

            $table->foreignId('work_order_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('profile_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();

            // Evita duplicados
            $table->unique(['work_order_id', 'profile_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_order_technician');
    }
};
