<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('role')->insert([
            ['libelle' => 'client'],
            ['libelle' => 'caissier'],
            ['libelle' => 'gestionnaire des stock'],
            ['libelle' => 'admin'],
        ]);
    }
}
