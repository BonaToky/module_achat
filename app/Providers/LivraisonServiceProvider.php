<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LivraisonServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(base_path('routes/routes_livraison.php'));
    }

    public function register()
    {
        // Ici tu peux enregistrer des services si nécessaire
    }
}