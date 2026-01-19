<?php

use App\Http\Controllers\LivraisonController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::get('/livraisons', [LivraisonController::class, 'index'])->name('livraisons.index');
    Route::get('/livraisons/create', [LivraisonController::class, 'create'])->name('livraisons.create');
    Route::post('/livraisons', [LivraisonController::class, 'store'])->name('livraisons.store');
    Route::get('/livraisons/{livraison}/edit', [LivraisonController::class, 'edit'])->name('livraisons.edit');
    Route::put('/livraisons/{livraison}', [LivraisonController::class, 'update'])->name('livraisons.update');
    Route::delete('/livraisons/{livraison}', [LivraisonController::class, 'destroy'])->name('livraisons.destroy');
    Route::get('/livraisons/{livraison}', [LivraisonController::class, 'show'])->name('livraisons.show');
});
