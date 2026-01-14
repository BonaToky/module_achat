<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorieSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categorie')->insert([
            ['libelle' => 'Électronique'],
            ['libelle' => 'Vêtements'],
            ['libelle' => 'Alimentation'],
        ]);
    }
}
