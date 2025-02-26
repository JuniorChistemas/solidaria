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


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->prefix('category') // ✅ Prefijo para evitar redundancia
    ->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('category.index'); // ✅ Cambio de nombre
        Route::get('/list', [CategoryController::class, 'listCategory'])->name('category.list');
        Route::post('add/', [CategoryController::class, 'store'])->name('category.store'); // ✅ Estándar RESTful
        Route::put('update/{category}', [CategoryController::class, 'update'])->name('category.update'); // ✅ RESTful
        Route::delete('delete/{category}', [CategoryController::class, 'destroy'])->name('category.destroy'); // ✅ RESTful
    });

