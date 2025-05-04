<?php

// use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', fn () => view('pages.auth.login'))->name('page.login');
    Route::get('register', fn () => view('pages.auth.register'))->name('page.register');
    // Route::post('login', [AuthController::class, 'login'])->name('login');
    // Route::post('register', [AuthController::class, 'register'])->name('register');
});

Route::middleware('auth')->group(function () {
    // Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});