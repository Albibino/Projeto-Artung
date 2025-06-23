<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@artung.com',
            'password' => Hash::make('admin123456'),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Albino',
            'email' => 'albino@gmail.com',
            'password' => Hash::make('albino123456'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Rafael',
            'email' => 'rafael@gmail.com',
            'password' => Hash::make('rafael123456'),
            'email_verified_at' => now(),
        ]);

    }
}
