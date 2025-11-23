<flux:card size="sm" class="space-y-2 mt-2 z-0">
    @forelse($history as $color)
            <flux:button
                data-test="color-box"
                wire:click="copy('{{ $color }}')"
                data-context
                data-color="{{ $color }}"
                class="hover:scale-110"
                style="background-color: {{ $color }}
                !important"/>
    @empty
        {{ __('No history yet') }}
    @endforelse
</flux:card>

@script
    <script>
        document.addEventListener('contextmenu', (event) => {
            const element = event.target.closest('[data-context]');

            if (! element) return;

            event.preventDefault();

            Native.contextMenu([
                {
                    label: 'Copy',
                    accelerator: 'Command+c',
                    click() {
                        $wire.copy(element.dataset.color);
                    },
                },
                {
                    label: 'Delete',
                    accelerator: 'Command+Backspace',
                    click() {
                        $wire.remove(element.dataset.color);
                    },
                },
            ]);
        });
    </script>
@endscript
