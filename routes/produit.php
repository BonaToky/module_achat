<?php

use App\Http\Controllers\ProduitController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::get('/produits', [ProduitController::class, 'index'])->name('produits.index');
});
