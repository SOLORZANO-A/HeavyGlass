<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('proformas', function (Blueprint $table) {
            $table->foreignId('work_order_id')
                  ->after('id')
                  ->constrained('work_orders')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('proformas', function (Blueprint $table) {
            $table->dropForeign(['work_order_id']);
            $table->dropColumn('work_order_id');
        });
    }
};
