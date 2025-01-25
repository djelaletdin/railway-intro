<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
use Inertia\Inertia;


Route::controller(CompanyController::class)->group(function () {
    Route::get('/', 'index')->name('company.index');
    Route::get('/company/{company:slug}', 'show')->name('company.show');
});

Route::prefix('admin')
    ->controller(AdminCompanyController::class)
    ->middleware(['auth'])
    ->name('admin.')
    ->group(function () {
        Route::get('/companies',  'index')->name('companies.index');
        Route::get('/companies/create','create')->name('companies.create');
        Route::post('/companies',  'store')->name('companies.store');
        Route::get('/companies/{company}/edit',  'edit')->name('companies.edit');
        Route::post('/companies/{company}', 'update')->name('companies.update');
        Route::delete('/companies/{company}','destroy')->name('companies.destroy');
    });


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
