<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UrlCsvController;


Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/websites', [WebsiteController::class, 'index'])->name('websites.index');
    Route::get('/websites/create', [WebsiteController::class, 'create'])->name('websites.create');
    Route::post('/websites', [WebsiteController::class, 'store'])->name('websites.store');
});


Route::middleware('auth')->group(function () {
    Route::get('/websites/{website}/urls', [UrlController::class, 'index'])->name('urls.index');
    Route::post('/websites/{website}/urls', [UrlController::class, 'store'])->name('urls.store');
});


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/clients/create', [AdminController::class, 'createClient'])->name('admin.clients.create');
    Route::post('/admin/clients', [AdminController::class, 'storeClient'])->name('admin.clients.store');
});


Route::middleware('auth')->group(function () {
    Route::get('/websites/{website}/csv-upload', [UrlCsvController::class, 'form'])->name('urls.csv.form');
    Route::post('/websites/{website}/csv-upload', [UrlCsvController::class, 'upload'])->name('urls.csv.upload');
});
