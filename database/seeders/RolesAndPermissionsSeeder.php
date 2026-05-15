<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset the permission cache.
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'products.read',
            'products.create',
            'products.update',
            'products.delete',
            'orders.read',
            'orders.manage',
        ];

        // Create permissions.
        foreach ($permissions as $perm) {
            Permission::findOrCreate($perm, 'web');
        }

        // Create roles.
        $owner = Role::findOrCreate('pemilik', 'web');
        $staff = Role::findOrCreate('pegawai', 'web');
        $renter = Role::findOrCreate('penyewa', 'web');

        // Owners can access everything.
        $owner->syncPermissions($permissions);

        // Staff can manage products and orders.
        $staff->syncPermissions($permissions);

        // Renters can only view products.
        $renter->syncPermissions([
            'products.read'
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
