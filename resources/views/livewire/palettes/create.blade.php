<?php

use App\Livewire\Forms\CreatePaletteForm;
use App\Models\Color;
use App\Models\Palette;
use function Livewire\Volt\{layout, state, mount};

state([
    'hex',
    'name',
    'picksHistory',
    'pickedColors',
    'existingColors',
    'fromColorHistory',
    'fromAnotherPalette',
]);

mount(function () {
    $this->picksHistory = Cache::get('picks-history', []);
    $this->existingColors = Color::all();
});

layout('components.layouts.app');

$pickColor = function () {
    $this->validate([
        'hex' => [
            'nullable',
            'hex_color',
        ],
    ]);

    if ($this->hex) {
        $this->pickedColors[] = $this->hex;
    }

    $this->pickedColors = collect([
        ...$this->pickedColors ?? [],
        ...$this->fromColorHistory ?? [],
        ...$this->fromAnotherPalette ?? [],
    ])
        ->filter()
        ->map(fn($hex) => strtolower($hex))
        ->unique()
        ->values();

    $this->hex = '';
    $this->fromColorHistory = [];
    $this->fromAnotherPalette = [];
};

$add = function ($color) {
    $this->hex = $color;
    $this->pickedColors[] = $this->hex;
    $this->hex = '';
};

$deleteColor = function ($color) {
    $this->pickedColors = collect($this->pickedColors)
        ->reject(fn($hex) => $hex === $color)
        ->values()
        ->toArray();
};

$save = function () {
    $this->validate([
        'name' => [
            'required',
            'string',
            'min:3',
        ],
    ]);

    $palette = Palette::create(['name' => $this->name]);

    if ($this->pickedColors) {
        Color::upsert(
            collect($this->pickedColors)->map(fn($hex) => ['hex' => $hex])->toArray(),
            ['hex']
        );

        $colors = Color::whereIn('hex', $this->pickedColors)->pluck('id');

        $palette->colors()->attach($colors);
    }

    $this->redirectRoute('home');
};
?>

<div>
    <flux:header>
        <flux:button href="{{ route('home') }}">Back</flux:button>
    </flux:header>

    <flux:main>
        <form wire:submit="save" class="space-y-6">
            <flux:input label="{{ __('Name') }}" wire:model="name" placeholder="Enter palette name"></flux:input>

            <flux:heading>
                {{ __('Pick colors') }}
            </flux:heading>
            <flux:card size="sm" class="space-y-2 mt-2">
                @forelse($pickedColors ?? [] as $color)
                    <flux:context>
                        <flux:button wire:click="copyColor('{{ $color }}')" class="cursor-pointer"
                                     style="background-color: {{ $color }} !important"/>

                        <flux:menu>
                            <flux:menu.item wire:click="deleteColor('{{ $color }}')" icon="trash"
                                            variant="danger">{{ __('Delete') }}</flux:menu.item>
                        </flux:menu>
                    </flux:context>
                @empty
                    {{ __('No picked colors yet') }}
                @endforelse
            </flux:card>

            <flux:field variant="inline" class="!flex">
                <flux:button
                    x-data
                    @click="new EyeDropper().open().then(r => $wire.add(r.sRGBHex.toUpperCase())).catch(e => {})"
                    class="cursor-pointer min-w-12"
                    icon="pipette"
                />

                <flux:input wire:model="hex" placeholder="Enter Hex Value"></flux:input>
            </flux:field>

            <flux:pillbox wire:model="fromColorHistory" multiple
                          placeholder="{{ __('Select from Color History') }}">
                @foreach($picksHistory as $color)
                    <flux:pillbox.option value="{{ $color }}">
                        <div class="flex items-center gap-2">
                            <flux:button class="cursor-pointer"
                                         style="background-color: {{ $color }} !important">
                            </flux:button>
                            <flux:text>{{ $color }}</flux:text>
                        </div>
                    </flux:pillbox.option>
                @endforeach
            </flux:pillbox>

            <flux:pillbox wire:model="fromAnotherPalette" multiple searchable
                          placeholder="{{ __('Select from Other Palettes') }}">
                @foreach($existingColors as $color)
                    <flux:pillbox.option value="{{ $color->hex }}">
                        <div class="flex items-center gap-2">
                            <flux:button class="cursor-pointer"
                                         style="background-color: {{ $color->hex }} !important">
                            </flux:button>
                            <flux:text>{{ $color->hex }}</flux:text>
                        </div>
                    </flux:pillbox.option>
                @endforeach
            </flux:pillbox>

            <flux:button class="cursor-pointer w-full" wire:click="pickColor">
                {{ __('Add To Palette') }}
            </flux:button>

            <flux:button type="submit" class="cursor-pointer w-full">{{ __('Create Palette') }}</flux:button>
        </form>
    </flux:main>
</div>
