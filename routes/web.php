<?php

use App\Admin\FeeManagement\FeeManagement;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {})->name('home');

Route::get('/fee-management', FeeManagement::class)
    ->name('admin.fee-management');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';
