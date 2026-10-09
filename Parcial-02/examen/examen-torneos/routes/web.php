<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TorneoController;
use App\Http\Controllers\TorneoPublicoController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\Admin\InscripcionController as AdminInscripcionController;



Route::redirect('/', '/torneos');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/torneos', [TorneoPublicoController::class, 'index'])->name('torneos.index');
Route::get('/torneos/{torneo}', [TorneoPublicoController::class, 'show'])->name('torneos.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



    Route::post('/torneos/{torneo}/inscripcion', [InscripcionController::class, 'store'])->name('inscripciones.store');
    Route::delete('/torneos/{torneo}/inscripcion', [InscripcionController::class, 'destroy'])->name('inscripciones.destroy');

    Route::get('/mis-torneos', [InscripcionController::class, 'index'])->name('inscripciones.index');
});

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('torneos', TorneoController::class)->except('show');
        Route::get('torneos/{torneo}/inscripciones', [AdminInscripcionController::class, 'index'])
            ->name('torneos.inscripciones.index');
        Route::delete('torneos/{torneo}/inscripciones/{user}', [AdminInscripcionController::class, 'destroy'])
            ->name('torneos.inscripciones.destroy');
    });



require __DIR__ . '/auth.php';
