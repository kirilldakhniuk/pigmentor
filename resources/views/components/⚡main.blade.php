<?php

use App\Models\Palette;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {
    public $history = [];

    public $palettes = [];

    public function mount(): void
    {
        $this->history = Cache::get('picks-history');

        $this->palettes = Palette::all()->sortDesc();
    }

    #[On('color-picked')]
    public function updateHistory()
    {
        $this->history = Cache::get('picks-history');
    }

    public function copyColor($color)
    {
        Clipboard::text($color);

        Flux::toast(
            variant: 'success',
            text: 'Color copied.',
            duration: 1000
        );
    }

    public function removeColor($color): void
    {
        $this->history = collect($this->history)
            ->reject(fn($hex) => $hex === $color)
            ->values()
            ->toArray();

        Cache::put('picks-history', $this->history);

        Flux::toast(
            variant: 'success',
            text: 'Color removed.',
            duration: 1000
        );
    }

    public function deletePalette($id)
    {
        Palette::find($id)->delete();

        $this->palettes = Palette::all()->sortDesc();

        Flux::toast(
            variant: 'success',
            text: 'Palette deleted.',
            duration: 1000
        );
    }
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
                        <flux:menu.item wire:click="copyColor('{{ $color }}')"
                                        icon="copy">{{ __('Copy') }}</flux:menu.item>
                        <flux:menu.item wire:click="removeColor('{{ $color }}')" icon="trash"
                                        variant="danger">{{ __('Remove') }}</flux:menu.item>
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
                        <flux:button icon="ellipsis-horizontal" variant="subtle"
                                     class="cursor-pointer hover:bg-transparent!"/>
                        <flux:menu>
                            <flux:navmenu.item href="{{ route('palettes.edit', $palette) }}"
                                               icon="pencil-square">{{ __('Edit') }}</flux:navmenu.item>
                            <flux:menu.item wire:click="deletePalette('{{ $palette->id }}')" icon="trash"
                                            variant="danger">{{ __('Remove') }}</flux:menu.item>
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
