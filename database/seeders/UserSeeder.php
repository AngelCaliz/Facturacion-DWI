<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'role' => 'ADMIN',
        ]);

        User::create([
            'name' => 'Vendedor Test',
            'email' => 'vendedor@local.com',
            'password' => Hash::make('vendedor123'),
            'role' => 'VENDEDOR',
        ]);
    }
}
