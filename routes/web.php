<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Volt::route('palettes/create', 'palettes.create')
    ->name('palettes.create');

Volt::route('palettes/{palette}/edit', 'palettes.edit')
    ->name('palettes.edit');
