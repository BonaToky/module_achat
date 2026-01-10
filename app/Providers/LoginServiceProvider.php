<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LoginServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(base_path('routes/routes_login.php'));
    }

    public function register()
    {
        // Ici tu peux enregistrer des services si nécessaire
    }
}