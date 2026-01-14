<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ProduitServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(base_path('routes/routes_produit.php'));
//         $this->loadRoutesFrom(base_path('routes/produit.php'));

    }

    public function register()
    {
        // Ici tu peux enregistrer des services si nécessaire
    }
}

