<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProduitSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('produit')->insert([
            [
                'nom' => 'Ordinateur Portable',
                'image' => null,
                'id_categorie' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'T-shirt',
                'image' => null,
                'id_categorie' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Pain',
                'image' => null,
                'id_categorie' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
