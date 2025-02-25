<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CategoryController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/category', [CategoryController::class, 'index'])->name('category');

    Route::prefix('category')->group(function () {
        Route::get('/list', [CategoryController::class, 'listCategory']);
        Route::post('/add', [CategoryController::class, 'store']);
        Route::put('/update/{category}', [CategoryController::class, 'update']); // Actualizar
        Route::delete('/delete/{category}', [CategoryController::class, 'destroy']); // Eliminar
    });
});
