<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'content-view')
    ->name('home');

Route::livewire('app-settings', 'app-settings')
    ->name('app.settings');

Route::livewire('floating-palette/{palette}', 'floating-palette')
    ->name('floating.palette');
