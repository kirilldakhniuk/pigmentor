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

test('add new palette button navigates user to palette create view', function () {
    Http::fake();

    $page = visit(route('home'))->on()->desktop();

    $page
        ->click('@add-new-palette')
        ->assertRoute('palettes.create')
        ->assertNoSmoke()
        ->assertNoConsoleLogs()
        ->assertNoJavaScriptErrors();
});
