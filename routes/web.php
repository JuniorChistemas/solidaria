<?php

use App\Http\Controllers\Autocomplete\SearchDoctorController;
use App\Http\Controllers\Autocomplete\SearchUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\ZoneController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SupplierController;

// SYSTEM START
Route::get('/', [DashboardController::class, 'Welcome'])->name('Welcome');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    // initial DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'Dashboard'])->name('dashboard');
    Route::prefix('modulo')->group(function () {
        // CRUD MODULES
        Route::resource('doctor', DoctorController::class)->except(['create', 'edit']);
        Route::resource('category', CategoryController::class)->except(['create', 'show']);
        Route::resource('laboratory', LaboratoryController::class)->except(['create', 'show']);
        Route::resource('zone', ZoneController::class)->except(['create', 'show']);
        Route::resource('supplier', SupplierController::class)->except(['create']);
        Route::resource('role', RoleController::class)->except(['create', 'edit']);
        // path/route to list
        Route::get('doctors/list', [DoctorController::class, 'listDoctor'])->name('doctor.list');
        Route::get('laboratories/list', [LaboratoryController::class, 'listLaboratory'])->name('laboratory.list');
        Route::get('categories/list', [CategoryController::class, 'listCategory'])->name('category.list');
        Route::get('zone/list', [ZoneController::class, 'listZone'])->name('zone.list');
        Route::get('roles/list', [RoleController::class, 'listRole'])->name('role.list');
        Route::get('suppliers/list', [SupplierController::class, 'listSupplier'])->name('supplier.list');
        // path/route to search

        // * view search
        Route::get('search', [SearchController::class, 'viewSearch'])->name('search');
        // * search for doctors by name
        Route::get('search/doctor', [SearchDoctorController::class, 'searchDoctor'])->name('search.doctor');





        // list permissions
        Route::get('permissions', [SearchUserController::class, 'getPermissions'])->name('permissions');
    });
});


Route::get('doctors/search', [DoctorController::class, 'searchDoctor'])->name('doctor.search');

Route::get('laboratories/search', [LaboratoryController::class, 'searchLaboratory'])->name('laboratory.search');

Route::get('zones/search', [ZoneController::class, 'searchZone'])->name('zone.search');
Route::get('categories/search', [ZoneController::class, 'searchCategory'])->name('category.search');
Route::get('category/list', [CategoryController::class, 'listCategory'])->name('category.list');
Route::post('category/add/', [CategoryController::class, 'store'])->name('category.store');
Route::put('category/update/{category}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('category/delete/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
