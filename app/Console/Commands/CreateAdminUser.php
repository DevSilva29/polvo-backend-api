<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'app:create-admin';
    protected $description = 'Cria um novo utilizador administrador';

    public function handle()
    {
        $username = $this->ask('Digite o nome de utilizador (email)');
        $password = $this->secret('Digite a senha');

        User::create([
            'admins_user' => $username,
            'admins_password' => Hash::make($password),
        ]);

        $this->info('Utilizador administrador criado com sucesso!');
    }
}