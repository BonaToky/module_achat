<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MouvementStockSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('mouvement_stock')->insert([
            [
                'type_mouvement_stock' => 'entree',
                'quantite' => 10,
                'date_mouv' => now(),
                'id_categorie' => 1,
                'id_produit' => 1,
            ],
            [
                'type_mouvement_stock' => 'entree',
                'quantite' => 50,
                'date_mouv' => now(),
                'id_categorie' => 2,
                'id_produit' => 2,
            ],
            [
                'type_mouvement_stock' => 'entree',
                'quantite' => 100,
                'date_mouv' => now(),
                'id_categorie' => 3,
                'id_produit' => 3,
            ],
        ]);
    }
}
