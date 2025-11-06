<?php

use function Livewire\Volt\{state, mount};

state('history');

mount(fn() => $this->history = Cache::get('picks-history', []));

$pickColor = function ($color) {
    Clipboard::text($color);

    $this->history[] = $color;

    Cache::put('picks-history', $this->history, now()->addMinute());

    $this->dispatch('color-picked', color: $color);
};

?>

<div>
    <flux:button
        x-data
        @click="new EyeDropper().open().then(r => $wire.pickColor(r.sRGBHex)).catch(e => {})"
        class="cursor-pointer"
        icon="pipette"
        square
    />

    <flux:button href="{{ route('palettes.create') }}" class="cursor-pointer" icon="plus" square/>

    <flux:button class="cursor-pointer" icon="cog" square/>
</div>
