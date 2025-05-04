<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return view('pages.test');
});
Route::get('/', function () {
    return view('app');
})->name('home');
