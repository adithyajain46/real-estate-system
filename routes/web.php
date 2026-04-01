<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ReportController;

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Auth routes (Laravel Breeze/UI handles these)
Auth::routes();

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Properties CRUD
Route::resource('properties', PropertyController::class);

// Clients CRUD
Route::resource('clients', ClientController::class);

// Reports
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
