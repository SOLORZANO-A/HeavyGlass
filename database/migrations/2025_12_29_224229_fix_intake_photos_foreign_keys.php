<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * 1️⃣ Eliminar FK incorrecta (si existe) en intake_sheets
         */
        Schema::table('intake_sheets', function (Blueprint $table) {
            // Evita error si no existe
            if (Schema::hasColumn('intake_sheets', 'intake_photo_id')) {
                $table->dropForeign(['intake_photo_id']);
                $table->dropColumn('intake_photo_id');
            }
        });

        /**
         * 2️⃣ Asegurar FK correcta en intake_photos
         */
        Schema::table('intake_photos', function (Blueprint $table) {

            // Si existe la FK, la eliminamos primero
            try {
                $table->dropForeign(['intake_sheet_id']);
            } catch (\Throwable $e) {
                // no pasa nada si no existe
            }

            // Crear FK correcta
            $table->foreign('intake_sheet_id')
                ->references('id')
                ->on('intake_sheets')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        /**
         * Rollback: eliminar FK correcta
         */
        Schema::table('intake_photos', function (Blueprint $table) {
            $table->dropForeign(['intake_sheet_id']);
        });
    }
};
