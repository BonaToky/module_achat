<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HistoryPrixProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(base_path('routes/routes_history_prix.php'));
    }

    public function register()
    {
        // Ici tu peux enregistrer des services si nécessaire
    }
}