<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

test('picking a color with the pipette adds it to cache history and fires color-picked event', function () {
    Cache::spy();

    Livewire::test('toolbar')
        ->call('pickColor', $color = fake()->hexColor)
        ->assertHasNoErrors()
        ->assertDispatched('color-picked', color: $color);

    Cache::shouldHaveReceived('put')
        ->once()
        ->with(
            'picks-history',
            Mockery::on(fn ($history) => in_array($color, $history)),
            Mockery::type(Carbon::class)
        );
});

test('add new palette button navigates user to palette create view', function () {
    Http::fake([
        'localhost:4000/api/clipboard/*' => Http::response(['text' => fake()->hexColor]),
    ]);

    $page = visit(route('home'))->on()->desktop();

    $page
        ->click('@add-new-palette')
        ->assertRoute('palettes.create')
        ->assertNoSmoke()
        ->assertNoConsoleLogs()
        ->assertNoJavaScriptErrors();
});
