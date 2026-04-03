<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'nama' => 'Super Admin',
            'email' => 'admin@atomix.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Akun Member
        User::create([
            'nama' => 'Member Aktif',
            'email' => 'member@atomix.com',
            'password' => Hash::make('password123'),
            'role' => 'member',
        ]);

        // 3. Akun User Biasa (Belum jadi member)
        User::create([
            'nama' => 'User Biasa',
            'email' => 'user@atomix.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);
    }
}