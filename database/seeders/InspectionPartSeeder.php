<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InspectionZone;
use App\Models\InspectionPart;

class InspectionPartSeeder extends Seeder
{
    public function run(): void
    {
        $partsByZone = [

            'front' => [
                'Parachoques delantero',
                'Capó',
                'Parabrisas',
                'Faros',
                'Parrilla',
                'Guardachoques',
            ],

            'right' => [
                'Puerta delantera derecha',
                'Puerta trasera derecha',
                'Vidrios laterales derechos',
                'Retrovisor derecho',
                'Llantas derechas',
                'Guardafangos derecho',
            ],

            'left' => [
                'Puerta delantera izquierda',
                'Puerta trasera izquierda',
                'Vidrios laterales izquierdos',
                'Retrovisor izquierdo',
                'Llantas izquierdas',
                'Guardafangos izquierdo',
            ],

            'rear' => [
                'Parachoques trasero',
                'Maletero / puerta trasera',
                'Luces traseras',
                'Vidrio posterior',
            ],

            'top' => [
                'Techo',
                'Rieles',
                'Antena',
            ],
        ];

        foreach ($partsByZone as $zoneCode => $parts) {

            $zone = InspectionZone::where('code', $zoneCode)->first();

            if (!$zone) {
                continue;
            }

            foreach ($parts as $partName) {
                InspectionPart::firstOrCreate([
                    'inspection_zone_id' => $zone->id,
                    'name' => $partName,
                ]);
            }
        }
    }
}
