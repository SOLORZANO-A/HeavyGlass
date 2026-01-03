<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proforma;
use App\Models\Payment;
use App\Models\Profile;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // ✅ Cajera (única)
        $cashier = Profile::firstOrCreate(
            ['staff_type' => 'cashier'],
            [
                'first_name' => 'Cajera',
                'last_name'  => 'Demo',
                'email'      => 'cajera@demo.com',
            ]
        );

        // ✅ Crear proformas
        $proformas = Proforma::factory()
            ->count(10)
            ->create();

        foreach ($proformas as $proforma) {

            // 👉 SOLO si está firmada
            if ($proforma->signature_status === 'signed') {

                Payment::factory()->create([
                    'proforma_id' => $proforma->id,
                    'cashier_id'  => $cashier->id,
                    'amount'      => $proforma->total,
                    'status'      => 'valid',
                ]);

                $proforma->update([
                    'status' => 'paid'
                ]);
            }
        }
    }
}
