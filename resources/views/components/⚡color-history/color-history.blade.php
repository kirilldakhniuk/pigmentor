<flux:heading>
    {{ __('Color History') }}
</flux:heading>

<flux:card size="sm" class="space-y-2 mt-2 z-0">
    @forelse($history as $color)
            <flux:button
                data-test="color-box"
                wire:click="copyColor('{{ $color }}')"
                class="hover:scale-110"
                style="background-color: {{ $color }} !important"
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
            />
    @empty
        {{ __('No history yet') }}
    @endforelse
</flux:card>
