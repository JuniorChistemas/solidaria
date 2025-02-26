<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\LaboratoryController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CategoryController;




// SYSTEM START
Route::get('/', [DashboardController::class, 'Welcome'])->name('Welcome');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    // initial DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'Dashboard'])->name('dashboard');
    Route::prefix('modulo')->group(function () {
        // CRUD MODULES
        Route::resource('doctor', DoctorController::class)->except(['create']);
        Route::resource('category', LaboratoryController::class)->except(['create']);
        Route::resource('laboratories', LaboratoryController::class)->except(['create']);
        // path/route to list
        Route::get('doctors/list', [DoctorController::class, 'listDoctor'])->name('doctor.list');
        Route::get('laboratories/list', [LaboratoryController::class, 'listLaboratory'])->name('laboratory.list');
        Route::get('categories/list', [CategoryController::class, 'listCategory'])->name('category.list');
    });
});
Route::get('doctors/search', [DoctorController::class, 'searchDoctor'])->name('doctor.search');
Route::get('laboratories/search', [LaboratoryController::class, 'searchLaboratory'])->name('laboratory.search');

