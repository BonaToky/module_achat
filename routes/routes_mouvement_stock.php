<?php

use App\Http\Controllers\MouvementStockController;

Route::get('/mouvement_stock', [MouvementStockController::class, 'index'])
    ->name('mouvements.index');

Route::get('/mouvement_stock/create', [MouvementStockController::class, 'create'])
    ->name('mouvements.create');

Route::get('/mouvement_stock/{mouvement}', [MouvementStockController::class, 'show'])
    ->name('mouvements.show');

Route::delete('/mouvement_stock/{mouvement}', [MouvementStockController::class, 'destroy'])
    ->name('mouvements.destroy');

Route::get('/mouvement_stock/filter', [MouvementStockController::class, 'filter'])
    ->name('mouvements.filter');

Route::post('/mouvement_stock', [MouvementStockController::class, 'store'])
    ->name('mouvements.store');
    