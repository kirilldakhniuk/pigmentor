<?php

use Livewire\Livewire;
use Native\Desktop\Facades\Settings;

test('color can be removed from history', function () {
    Settings::shouldReceive('get')
        ->with('keep-history', config('app.keep_history'))
        ->andReturn(config('app.keep_history'));

    $component = Livewire::test('color-history')
        ->call('setHistory', [$color = fake()->hexColor]);

    expect($component->history)->toContain($color);

    $component->call('remove', $color);

    expect($component->history)->not->toContain($color);
});
