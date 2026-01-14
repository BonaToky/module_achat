<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class VenteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(base_path('routes/vente.php'));
    }

    public function register()
    {
        //
    }
}
