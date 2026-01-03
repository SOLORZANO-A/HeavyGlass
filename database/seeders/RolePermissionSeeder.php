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
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 🔑 PERMISOS
        $permissions = [
            // Clients
            'clients.view',
            'clients.create',
            'clients.edit',

            // Vehicles
            'vehicles.view',
            'vehicles.create',
            'vehicles.edit',

            // Intake Sheets
            'intake_sheets.view',
            'intake_sheets.create',
            'intake_sheets.photos',

            // Proformas
            'proformas.view',
            'proformas.create',
            'proformas.edit',
            'proformas.approve',

            // Work Orders
            'work_orders.view',
            'work_orders.assign',
            'work_orders.update_status',
            'work_orders.time_tracking',

            // Work Types
            'work_types.manage',

            // Payments
            'payments.view',
            'payments.create',
            'payments.receipts',

            // Profiles
            'profiles.view',
            'profiles.edit',

            // Users & Reports
            'users.manage',
            'reports.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 🎭 ROLES
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $advisor = Role::firstOrCreate(['name' => 'advisor']);
        $workshopManager = Role::firstOrCreate(['name' => 'workshop_manager']);
        $cashier = Role::firstOrCreate(['name' => 'cashier']);

        // 🟥 ADMIN → todo
        $admin->syncPermissions(Permission::all());

        // 🟦 ADVISOR
        $advisor->syncPermissions([
            'clients.view',
            'clients.create',
            'clients.edit',

            'vehicles.view',
            'vehicles.create',
            'vehicles.edit',

            'intake_sheets.view',
            'intake_sheets.create',
            'intake_sheets.photos',

            'proformas.view',
            'proformas.create',

            'profiles.view',
            'profiles.edit',
        ]);

        // 🟨 WORKSHOP MANAGER
        $workshopManager->syncPermissions([
            'vehicles.view',

            'intake_sheets.view',

            'work_orders.view',
            'work_orders.assign',
            'work_orders.update_status',
            'work_orders.time_tracking',

            'work_types.manage',
        ]);

        // 🟩 CASHIER
        $cashier->syncPermissions([
            'proformas.view',

            'payments.view',
            'payments.create',
            'payments.receipts',

            'reports.view',
        ]);
    }
}
