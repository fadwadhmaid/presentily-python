<?php
// routes/web.php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/courses/{id}/chapters/{chapterId}', fn() => view('welcome'));
Route::get('/courses/{id}/lesson', fn() => view('welcome'));
// Pages supplémentaires
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');