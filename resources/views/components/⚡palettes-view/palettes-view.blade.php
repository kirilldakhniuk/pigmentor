<div>
    <h3 class="heading-label mb-2">
        {{ __('Palettes') }}
    </h3>

    <div wire:sort="movePalette" class="space-y-1">
        @forelse($palettes as $palette)
            <livewire:palette-view
                :$palette
                wire:key="{{ $palette->id }}"
                wire:sort:item="{{ $palette->id }}"
            />
        @empty
            <p class="text-muted text-sm">{{ __('No palettes yet') }}</p>
        @endforelse
    </div>
</div>
