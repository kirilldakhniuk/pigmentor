<?php

use App\Models\Color;
use App\Models\Palette;
use Livewire\Livewire;

test('a color can be moved to another palette', function () {
    [$sourcePalette, $targetPalette] = Palette::factory()
        ->count(2)
        ->create();

    $color = Color::factory()
        ->create();

    $sourcePalette
        ->colors()
        ->attach($color);

    Livewire::test('palette-view', ['palette' => $targetPalette])
        ->call('moveColor', "{$sourcePalette->id}:{$color->id}", 0);

    expect($sourcePalette->fresh()->colors->pluck('id'))
        ->not
        ->toContain($color->id);

    expect($targetPalette->fresh()->colors->pluck('id'))
        ->toContain($color->id);
});
