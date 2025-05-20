<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;

Route::middleware('guest')->group(function () {
    // auth routes
    Route::get('login', fn() => view('pages.auth.login'))->name('page.login');
    Route::get('register', fn() => view('pages.auth.register'))->name('page.register');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');

    // reset password routes
    Route::get('/forgot-password', fn() => view('pages.auth.forgot-password'))->name('password.request');
    Route::post('/forgot-password', [ResetPasswordController::class, 'forgotPassword'])->name('password.email');
    Route::get('/reset-password/{token}', fn(string $token) => view('pages.auth.reset-password', ['token' => $token]))->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    // verify email routes
    Route::get('/email/verify', fn() => view('pages.auth.verify-email'))->name('verification.notice')->middleware('not-verified');
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'emailVerify'])->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [VerifyEmailController::class, 'emailVerificationNotification'])->middleware('throttle:6,1')->name('verification.send');

    // logout route
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
