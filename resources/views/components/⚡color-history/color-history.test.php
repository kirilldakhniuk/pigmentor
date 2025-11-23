<?php

use Livewire\Livewire;

test('color can be removed from history', function () {
    $component = Livewire::test('color-history')
        ->call('setHistory', [$color = fake()->hexColor]);

    expect($component->history)->toContain($color);

    $component->call('remove', $color);

    expect($component->history)->not->toContain($color);
});
