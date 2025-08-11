<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortenerController;

Route::get('/', [ShortenerController::class, 'index'])->name('home');
Route::post('/shorten', [ShortenerController::class, 'store'])->name('shorten');
Route::get('/{code}', [ShortenerController::class, 'redirect'])->name('redirect');
