<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InspectionZone;

class InspectionZoneSeeder extends Seeder
{
    public function run(): void
    {
        $zones = [
            ['name' => 'Frontal', 'code' => 'front'],
            ['name' => 'Lateral Derecho', 'code' => 'right'],
            ['name' => 'Lateral Izquierdo', 'code' => 'left'],
            ['name' => 'Posterior', 'code' => 'rear'],
            ['name' => 'Superior / Techo', 'code' => 'top'],
        ];

        foreach ($zones as $zone) {
            InspectionZone::firstOrCreate(
                ['code' => $zone['code']],
                ['name' => $zone['name']]
            );
        }
    }
}
