<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ProduitServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(base_path('routes/produit.php'));
    }

    public function register()
    {
        //
    }
}
