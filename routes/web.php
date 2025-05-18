<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return view('pages.result.result-submit');
})->name('test');

// Glopal Routes.
Route::get('/', function () {
    return view('app');
})->name('home');

// Auth Protected Routes.
Route::middleware('auth')->group(function () {
    Route::resource('assessments', AssessmentController::class);
    Route::resource('questions', QuestionController::class)->except('index');
    Route::get('{assessment}/questions', [QuestionController::class, 'index'])->name('questions.index');
    Route::get('assessments-policy/{assessment}', [AssessmentController::class, 'policy'])->middleware('check.allow.take.assessment')->name('assessments.policy');

    Route::resource('results', ResultController::class)->except('create');
    Route::get('results/participant/details/{result}', [ResultController::class, 'resultDetailsForParticipant'])->name('results.participant.details');
    Route::get('results/create/{assessment}', [ResultController::class, 'create'])->middleware('check.allow.take.assessment')->name('results.create');
    Route::get('results/submit-review/{result}', [ResultController::class, 'submitReview'])->middleware('check.result.submit')->name('results.review.submit');
    Route::post('results/submit-result/{result}', [ResultController::class, 'submitResult'])->name('results.submit');

    Route::get('index', [AppController::class, 'getStarted'])->name('get.started');

    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    
    Route::get('settings', fn () => view('pages.settings.settings'))->name('settings.index');
    Route::put('settings/update-info', [SettingController::class, 'updateInfo'])->name('settings.update.info');
    Route::put('settings/reset-password', [SettingController::class, 'resetPassword'])->name('settings.reset.password');
    Route::delete('settings/delete-account', [SettingController::class, 'deleteAcount'])->name('settings.delete.account');
});

// Guest Protected Routes.
Route::middleware('guest')->group(function () {

});

require __DIR__.'/auth.php';