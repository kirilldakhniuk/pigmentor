<?php

use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

it('dispatches event when color is picked', function () {
    Http::fake();

    Livewire::test('toolbar')
        ->call('pickColor', $color = fake()->hexColor)
        ->assertHasNoErrors()
        ->assertDispatched('color-picked', color: $color);
});
