<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar caché de permisos
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | PERMISOS GLOBALES (1 permiso = 1 módulo)
        |--------------------------------------------------------------------------
        */
        $permissions = [
            'manage clients',
            'manage vehicles',
            'manage intake sheets',
            'manage work orders',
            'manage proformas',
            'manage payments',
            'manage users',
            'manage profiles',
            'manage work types',
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ROLES
        |--------------------------------------------------------------------------
        */
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $advisor = Role::firstOrCreate(['name' => 'advisor', 'guard_name' => 'web']);
        $workshopManager = Role::firstOrCreate(['name' => 'workshop_manager', 'guard_name' => 'web']);
        $cashier = Role::firstOrCreate(['name' => 'cashier', 'guard_name' => 'web']);

        /*
        |--------------------------------------------------------------------------
        | ASIGNACIÓN DE PERMISOS
        |--------------------------------------------------------------------------
        */

        // ADMIN → acceso total
        $admin->syncPermissions(Permission::all());

        // ADVISOR
        $advisor->syncPermissions([
            'manage clients',
            'manage vehicles',
            'manage intake sheets',
            'manage proformas',
            'manage profiles',
        ]);

        // WORKSHOP MANAGER
        $workshopManager->syncPermissions([
            'manage vehicles',
            'manage intake sheets',
            'manage work orders',
            'manage work types',
        ]);

        // CASHIER
        $cashier->syncPermissions([
            'manage proformas',
            'manage payments',
            'view reports',
        ]);
    }
}
