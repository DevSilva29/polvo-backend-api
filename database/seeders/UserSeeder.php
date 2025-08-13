<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Importante para criptografar a senha
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Apaga usuários existentes para evitar duplicatas ao rodar o seeder várias vezes
        User::truncate();

        User::create([
            'name' => 'Admin Polvo',
            'email' => 'admin@polvo.com', // Use este email para logar
            'password' => Hash::make('123456'), // Use esta senha para logar
        ]);
    }
}