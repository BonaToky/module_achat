<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MouvementStockServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(base_path('routes/routes_mouvement_stock.php'));
    }

    public function register()
    {
        // Ici tu peux enregistrer des services si nécessaire
    }
}