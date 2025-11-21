<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@pagee.com'], // pencarian
            [
                'nama' => 'Administrator',
                'email' => 'admin@pagee.com',
                'password' => Hash::make('admin12345'),
                'role' => 'admin',
                'foto' => null,
                'bio' => 'Super admin',
            ]
        );
    }
}
