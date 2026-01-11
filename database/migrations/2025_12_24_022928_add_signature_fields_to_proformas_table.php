<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('proformas', function (Blueprint $table) {
            $table->string('signature_status')
                ->default('pending')
                ->after('status');

            $table->string('client_signature')
                ->nullable()
                ->after('signature_status');

            $table->timestamp('signed_at')
                ->nullable()
                ->after('client_signature');
        });
    }

    public function down(): void
    {
        Schema::table('proformas', function (Blueprint $table) {
            $table->dropColumn([
                'signature_status',
                'client_signature',
                'signed_at'
            ]);
        });
    }
};
