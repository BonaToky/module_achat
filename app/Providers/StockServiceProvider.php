<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CategorieServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(base_path('routes/routeStock.php'));
    }

    public function register()
    {
        // Ici tu peux enregistrer des services si nécessaire
    }
}
