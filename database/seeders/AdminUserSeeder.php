<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Evitar duplicados
        $user = User::firstOrCreate(
            ['email' => 'admintotal@admin.com'],
            [
                'name' => 'Administrador General',
                'password' => Hash::make('admin1812'),
            ]
        );

        // Crear perfil si no existe
        Profile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => 'Admin',
                'last_name' => 'Total',
                'specialization' => 'Administración del sistema',
            ]
        );

        // Asignar rol admin (Spatie)
        if (!$user->hasRole('admin')) {
            $user->assignRole('admin');
        }
    }
}
