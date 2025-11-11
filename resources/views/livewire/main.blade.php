<?php

use App\Models\Palette;
use Illuminate\Support\Facades\Cache;
use Native\Desktop\Facades\Clipboard;
use Flux\Flux;
use function Livewire\Volt\{layout, state, mount, on};

state(['history', 'palettes']);

layout('components.layouts.app');

mount(function () {
    $this->history = Cache::get('picks-history', []);

    $this->palettes = Palette::all()->sortDesc();
});

on([
    'color-picked' => fn() => $this->history = Cache::get('picks-history', []),
]);

$copyColor = function ($color) {
    Clipboard::text($color);

    Flux::toast(
        variant: 'success',
        text: 'Color copied.',
        duration: 1000
    );
};

$deleteColor = function ($color) {
    $this->history = collect($this->history)
        ->reject(fn($hex) => $hex === $color)
        ->values()
        ->toArray();

    Cache::put('picks-history', $this->history);

    Flux::toast(
        variant: 'success',
        text: 'Color deleted.',
        duration: 1000
    );
};

$deletePalette = function ($id) {
    Palette::find($id)->delete();

    $this->palettes = Palette::all()->sortDesc();

    Flux::toast(
        variant: 'success',
        text: 'Palette deleted.',
        duration: 1000
    );
};

?>

<div>
    <flux:accordion.item heading="{{ __('Color History') }}" expanded>
        <flux:card size="sm" class="space-y-2 mt-2">
            @forelse($history as $color)
                <flux:context>
                    <flux:button wire:click="copyColor('{{ $color }}')" class="cursor-pointer"
                                 style="background-color: {{ $color }} !important"/>

                    <flux:menu>
                        <flux:menu.item wire:click="copyColor('{{ $color }}')" icon="copy">{{ __('Copy') }}</flux:menu.item>
                        <flux:menu.item wire:click="deleteColor('{{ $color }}')" icon="trash"
                                        variant="danger">{{ __('Delete') }}</flux:menu.item>
                    </flux:menu>
                </flux:context>
            @empty
                {{ __('No history yet') }}
            @endforelse
        </flux:card>
    </flux:accordion.item>

    <flux:accordion.item heading="{{ __('Palettes') }}" expanded>
        @foreach($palettes as $palette)
            <flux:card size="sm" class="space-y-2 my-2">
            <div class="flex justify-between items-center">
                <flux:heading>
                    {{ $palette->name }}
                </flux:heading>

                <flux:dropdown>
                    <flux:button icon="ellipsis-horizontal" variant="subtle" class="cursor-pointer hover:bg-transparent!"/>
                    <flux:menu>
                        <flux:navmenu.item href="{{ route('palettes.edit', $palette) }}" icon="pencil-square">{{ __('Edit') }}</flux:navmenu.item>
                        <flux:menu.item wire:click="deletePalette('{{ $palette->id }}')" icon="trash" variant="danger">{{ __('Remove') }}</flux:menu.item>
                    </flux:menu>
                </flux:dropdown>
            </div>

            @foreach($palette->colors as $color)
                <flux:context>
                    <flux:button wire:click="copyColor('{{ $color->hex }}')" class="cursor-pointer"
                                 style="background-color: {{ $color->hex }} !important"/>

                    <flux:menu>
                        <flux:menu.item wire:click="copyColor('{{ $color->hex }}')"
                                        icon="copy">{{ __('Copy') }}</flux:menu.item>
                    </flux:menu>
                </flux:context>
            @endforeach
            </flux:card>
        @endforeach
    </flux:accordion.item>
</div>
