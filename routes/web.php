<?php

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return view('pages.test');
});

// Glopal Routes.
Route::get('/', function () {
    return view('app');
})->name('home');

// Auth Protected Routes.
Route::middleware('auth')->group(function () {
    Route::get('index', [AppController::class, 'getStarted'])->name('get.started');
});

// Guest Protected Routes.
Route::middleware('auth')->group(function () {

});

require __DIR__.'/auth.php';