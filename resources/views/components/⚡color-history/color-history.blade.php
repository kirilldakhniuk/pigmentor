<div>
    <h3 class="heading-label mb-2">
        {{ __('History') }}
    </h3>

    <div
        class="card p-3 flex flex-wrap gap-2"
        wire:sort="reorderHistory"
        wire:sort:group="colors"
    >
        @forelse($history as $color)
            <button
                type="button"
                wire:sort:item="history:{{ $color }}"
                data-test="color-box"
                wire:click="copyColor('{{ $color }}')"
                class="color-swatch w-8 h-8 rounded-lg cursor-pointer border-0"
                style="background-color: {{ $color }}"
                x-on:contextmenu="Native.contextMenu([
                    {
                        label: 'Copy',
                        accelerator: 'Command+c',
                        click: async () => $wire.copyColor('{{ $color }}'),
                    },
                    {
                        label: 'Delete',
                        accelerator: 'Command+Backspace',
                        click: async () => $wire.remove('{{ $color }}'),
                    },
                ]);"
            ></button>
        @empty
            <p class="text-muted text-sm">{{ __('No history yet') }}</p>
        @endforelse
    </div>
</div>
