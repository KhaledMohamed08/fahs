<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return view('pages.foundation.profile');
})->name('test');

// Glopal Routes.
Route::get('/', function () {
    return view('app');
})->name('home');

// Auth Protected Routes.
Route::middleware('auth')->group(function () {
    Route::resource('assessments', AssessmentController::class);
    Route::get('index', [AppController::class, 'getStarted'])->name('get.started');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
});

// Guest Protected Routes.
Route::middleware('auth')->group(function () {

});

require __DIR__.'/auth.php';