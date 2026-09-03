<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PortfolioApiController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'index'])->name('home');

Route::get('/resume', [ResumeController::class, 'index'])->name('resume');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/api/portfolio', [PortfolioApiController::class, 'index'])->name('api.portfolio');
