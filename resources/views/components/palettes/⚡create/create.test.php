<?php

use Livewire\Livewire;

it('requires palette name', function () {
    $component = Livewire::test('palettes.create');

    $component->call('save')->assertHasErrors([
        'form.name' => ['required'],
    ]);
});

it('requires picked color to be valid hex color', function () {
    $component = Livewire::test('palettes.create');

    $component->set('hex', 'string');

    $component->assertHasErrors([
        'hex' => ['hex_color'],
    ]);
});

test('new palette can be added', function () {
    $component = Livewire::test('palettes.create')
        ->set('form.name', fake()->word);

    $component
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirectToRoute('home');
});
