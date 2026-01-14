<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HistoriquePrixSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('historique_prix')->insert([
            [
                'id_produit' => 1,
                'prix_achat' => 500.00,
                'prix_vente' => 700.00,
                'date_debut' => now(),
                'date_fin' => null,
            ],
            [
                'id_produit' => 2,
                'prix_achat' => 10.00,
                'prix_vente' => 20.00,
                'date_debut' => now(),
                'date_fin' => null,
            ],
            [
                'id_produit' => 3,
                'prix_achat' => 1.00,
                'prix_vente' => 2.00,
                'date_debut' => now(),
                'date_fin' => null,
            ],
        ]);
    }
}
