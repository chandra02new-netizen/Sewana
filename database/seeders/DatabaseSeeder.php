<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create permissions before creating users.
        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);

        // 2. Create primary accounts.
        $owner = User::firstOrCreate(
            ['email' => 'pemilik@sewana.test'],
            ['name' => 'Pemilik Sewana', 'password' => Hash::make('password')]
        );
        $owner->syncRoles('pemilik');

        $staff = User::firstOrCreate(
            ['email' => 'pegawai@sewana.test'],
            ['name' => 'Pegawai Sewana', 'password' => Hash::make('password')]
        );
        $staff->syncRoles('pegawai');

        $renter = User::firstOrCreate(
            ['email' => 'penyewa@sewana.test'],
            ['name' => 'Penyewa Sewana', 'password' => Hash::make('password')]
        );
        $renter->syncRoles('penyewa');

        // 3. Create 10 random customers so the users table has sample data.
        User::factory(10)->create()->each(function ($user) {
            $user->syncRoles('penyewa');
        });

        // 4. Create products.
        $this->call([
            ProductSeeder::class,
        ]);

        // AdminSeeder does not need to be called again because it is handled above.
    }
}
