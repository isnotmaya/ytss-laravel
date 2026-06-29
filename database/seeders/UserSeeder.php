<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            [
                'kd_users' => 'ADM001',
                'name' => 'Administrator',
                'email' => 'admin@ytss.com',
                'role' => 'manajemen',
                'status_aktif' => true,
                'password' => Hash::make('admin123')
            ]
        );
    }
}
