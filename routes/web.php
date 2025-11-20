<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    // Rutas de recursos para usuarios
    Route::resource('users', \App\Http\Controllers\UserController::class);

    // Rutas de recursos para categorías
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);

    // Rutas de recursos para productos
    Route::resource('products', \App\Http\Controllers\ProductController::class);

    // Rutas de recursos para órdenes
    Route::resource('orders', \App\Http\Controllers\OrderController::class);

    // Rutas de recursos para detalles de órdenes
    Route::resource('order-details', \App\Http\Controllers\OrderDetailController::class);

    // Rutas de recursos para evaluaciones
    Route::resource('evaluations', \App\Http\Controllers\EvaluationController::class);
});

require __DIR__.'/settings.php';
