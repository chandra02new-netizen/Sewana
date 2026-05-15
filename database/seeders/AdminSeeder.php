<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure the owner role exists.
        $ownerRole = Role::firstOrCreate(['name' => 'pemilik']);

        // Find the primary owner user.
        $user = User::where('email', 'pemilik@sewana.test')->first();

        if ($user) {
            // Keep this user assigned as owner.
            $user->syncRoles([$ownerRole->name]);
            echo "✅ Pemilik Utama berhasil dipulihkan!\n";
        } else {
            // Create the default owner user if it does not exist.
            $user = User::create([
                'name' => 'Pemilik Sewana',
                'email' => 'pemilik@sewana.test',
                'password' => bcrypt('password123'),
            ]);

            $user->assignRole($ownerRole);
            echo "🆕 Pemilik berhasil dibuat (email: pemilik@sewana.test, pw: password123)\n";
        }
    }
}
