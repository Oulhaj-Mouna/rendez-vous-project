<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Créer les rôles
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'client']);
        Role::firstOrCreate(['name' => 'prestataire']);

        // Créer l'admin (toi)
        $admin = User::firstOrCreate(
            ['email' => 'admin@rdv.ma'],
            [
                'name'      => 'Admin',
                'password'  => bcrypt('password'),
                'role'      => 'admin',
                'is_active' => true,
            ]
        );
        $admin->assignRole('admin');
    }
}