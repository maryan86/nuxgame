<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RegistrationController::class, 'index'])->name('home');
Route::post('/register', [RegistrationController::class, 'register'])->name('register');

Route::get('/link/{token}', [LinkController::class, 'show'])->name('link.show');
Route::post('/link/{token}/regenerate', [LinkController::class, 'regenerate'])->name('link.regenerate');
Route::post('/link/{token}/deactivate', [LinkController::class, 'deactivate'])->name('link.deactivate');

Route::post('/game/{token}/play', [GameController::class, 'play'])->name('game.play');
Route::get('/game/{token}/history', [GameController::class, 'history'])->name('game.history');
