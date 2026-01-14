<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nom' => 'Doe',
                'prenom' => 'John',
                'numero' => '1234567890',
                'password_hash' => Hash::make('password'),
                'adress' => '123 Main St',
                'solde' => 0,
                'id_role' => 1,
                'actif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Admin',
                'prenom' => 'System',
                'numero' => '0987654321',
                'password_hash' => Hash::make('admin'),
                'adress' => 'Admin Address',
                'solde' => 0,
                'id_role' => 4,
                'actif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
