<?php

use function Livewire\Volt\{state, mount};

state('history');

mount(fn() => $this->history = Cache::get('picks-history', []));

$pickColor = function ($color) {
    Clipboard::text($color);

    $this->history[] = $color;

    Cache::put('picks-history', $this->history, now()->addWeek());

    $this->dispatch('color-picked', color: $color);
};

?>

<div class="flex justify-between w-full">
    <flux:button
        x-data
        @click="new EyeDropper().open().then(r => $wire.pickColor(r.sRGBHex)).catch(e => {})"
        class="cursor-pointer"
        icon="pipette"
        square
    />

    <flux:button href="{{ route('palettes.create') }}" data-test="add-new-palette" class="cursor-pointer" icon="plus">
        {{ __('Add New Palette') }}
    </flux:button>
</div>
