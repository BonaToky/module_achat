<?php

use App\Http\Controllers\HistoriquePrixController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
Route::get('/historique-prix', [HistoriquePrixController::class, 'index'])->name('historique-prix.index');
Route::get('/historique-prix/create', [HistoriquePrixController::class, 'create'])->name('historique-prix.create');
Route::post('/historique-prix', [HistoriquePrixController::class, 'store'])->name('historique-prix.store');
Route::get('/historique-prix/{historiquePrix}/edit', [HistoriquePrixController::class, 'edit'])->name('historique-prix.edit');
Route::put('/historique-prix/{historiquePrix}', [HistoriquePrixController::class, 'update'])->name('historique-prix.update');
Route::delete('/historique-prix/{historiquePrix}', [HistoriquePrixController::class, 'destroy'])->name('historique-prix.destroy');
Route::get('/historique-prix/{historiquePrix}', [HistoriquePrixController::class, 'show'])->name('historique-prix.show');
});
