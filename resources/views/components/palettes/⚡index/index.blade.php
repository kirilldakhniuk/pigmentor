<flux:heading>
    {{ __('Palettes') }}
</flux:heading>
<div wire:sort="movePalette">
    @foreach($palettes ?? [] as $palette)
        <livewire:palettes.show
            :$palette
            wire:key="{{ $palette->id }}"
            wire:sort:item="{{ $palette->id }}"
        />
    @endforeach
</div>

