<?php

use App\Models\Palette;
use Livewire\Livewire;

it('requires palette name', function () {
    $palette = Palette::factory()->create();

    $component = Livewire::test('palettes.edit', [
        'palette' => $palette,
    ]);

    $component->set('form.name', '');

    $component->call('save')->assertHasErrors([
        'form.name' => ['required'],
    ]);
});

it('requires entered color to be valid hex color', function () {
    $palette = Palette::factory()->create();

    $component = Livewire::test('palettes.edit', [
        'palette' => $palette,
    ]);

    $component->set('hex', 'string');

    $component->assertHasErrors([
        'hex' => ['hex_color'],
    ]);
});

test('palette name can be updated', function () {
    $palette = Palette::factory()->create([
        'name' => 'foo',
    ]);

    $component = Livewire::test('palettes.edit', ['palette' => $palette])
        ->set('form.name', 'bar');

    $component
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirectToRoute('home');

    expect($palette->refresh()->name)->toEqual('bar');
});

test('a color can be added to palette', function () {
    $palette = Palette::factory()->create();

    $component = Livewire::test('palettes.edit', ['palette' => $palette]);

    $color = fake()->hexColor;

    expect($palette->colors->pluck('hex'))->not->toContain($color);

    $component->set('form.colors', [$color]);

    $component
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirectToRoute('home');

    expect($palette->refresh()->colors->pluck('hex'))->toContain($color);
});
