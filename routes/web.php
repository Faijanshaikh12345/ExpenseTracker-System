<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionsController;
use Illuminate\Support\Facades\Route;



Route::get('/login', [DashboardController::class, 'showLoginForm'])->name('login');

Route::post('/login', [DashboardController::class, 'login']);

Route::get('/register', [DashboardController::class, 'showRegistrationForm'])->name('register');

Route::post('/register', [DashboardController::class, 'register']);

Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])
        ->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('payments', PaymentMethodController::class);
    Route::resource('transactions', TransactionsController::class);

    // routes/web.php
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // report
    Route::get('/reports',              [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports_excel');
});
