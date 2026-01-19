<?php

use App\Http\Controllers\VenteController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::get('/ventes/create', [VenteController::class, 'create'])->name('ventes.create');

    Route::post('/ventes/add-to-cart', [VenteController::class, 'addToCart'])->name('ventes.addToCart');


    Route::get('/panier/create', [VenteController::class, 'indexPanier'])->name('panier.index');

    Route::post('/panier/add-to-cart', [VenteController::class, 'addToCart'])->name('panier.addToCart');

    Route::delete('/ventes/remove-from-cart/{id_produit}', [VenteController::class, 'removeFromCart'])->name('ventes.removeFromCart');
    Route::post('/ventes', [VenteController::class, 'store'])->name('ventes.store');
    Route::get('/ventes/{id_ticket}', [VenteController::class, 'show'])->name('ventes.show');
});
