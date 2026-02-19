<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Mohiuddin Asad',
            'email' => 'mohiuddinasad46@gmail.com',
            'password' => Hash::make('Asad6251'),
        ]);

        $user->assignRole('super_admin');
    }
}
