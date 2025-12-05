<div>
    <flux:heading>
        {{ __('Palettes') }}
    </flux:heading>

    <div wire:sort="movePalette">
        @forelse($palettes as $palette)
            <livewire:palette-view
                :$palette
                wire:key="{{ $palette->id }}"
                wire:sort:item="{{ $palette->id }}"
            />
        @empty
            <flux:text>
                {{ __('No Palettes') }}
            </flux:text>
        @endforelse
    </div>
</div>
