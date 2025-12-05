<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'content-view')
    ->name('home');

Route::livewire('palettes/create', 'palettes.create')
    ->name('palettes.create');

Route::livewire('palettes/{palette}/edit', 'palettes.edit')
    ->name('palettes.edit');

Route::livewire('app-settings', 'app-settings')
    ->name('app.settings');
