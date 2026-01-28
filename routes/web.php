<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/realtime', [DashboardController::class, 'realtime'])->name('realtime');
    Route::get('/audience', [DashboardController::class, 'audience'])->name('audience');
    Route::get('/geography', [DashboardController::class, 'geography'])->name('geography');
    Route::get('/devices', [DashboardController::class, 'devices'])->name('devices');
    Route::get('/acquisition', [DashboardController::class, 'acquisition'])->name('acquisition');
    Route::get('/system', [DashboardController::class, 'system'])->name('system');
    Route::get('/pages', [DashboardController::class, 'pages'])->name('pages');

    Route::get('/websites/create', [DashboardController::class, 'createWebsite'])->name('website.create');
    Route::post('/websites', [DashboardController::class, 'storeWebsite'])->name('website.store');
    Route::post('/website/switch', [DashboardController::class, 'switchWebsite'])->name('website.switch');
    Route::get('/export-csv', [DashboardController::class, 'exportCsv'])->name('export.csv');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});
