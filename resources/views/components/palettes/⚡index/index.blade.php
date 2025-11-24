<flux:accordion.item heading="{{ __('Palettes') }}" expanded>
    <div wire:sort="movePalette">
        @foreach($palettes ?? [] as $palette)
            <flux:card
                size="sm"
                class="space-y-2 my-2"
                wire:key="{{ $palette->id }}"
                wire:sort:item="{{ $palette->id }}"
            >
                <div class="flex justify-between items-center">
                    <flux:heading>
                        {{ $palette->title }}
                    </flux:heading>

                        <flux:button
                            icon="ellipsis-horizontal"
                            variant="subtle"
                            class="hover:bg-transparent!"
                            x-on:click="Native.contextMenu([
                                {
                                    label: 'Edit',
                                    accelerator: 'Command+e',
                                    click: async () => $wire.edit('{{ $palette->id }}'),
                                },
                                {
                                    label: 'Delete',
                                    accelerator: 'Command+d',
                                    click: async () => $wire.delete('{{ $palette->id }}'),
                                },
                            ]);"
                        />

                </div>

                @foreach($palette->colors ?? [] as $color)
                        <flux:button
                            wire:click="copyColor('{{ $color->hex }}')"
                            class="hover:scale-110"
                            style="background-color: {{ $color->hex }} !important"
                            x-on:contextmenu="Native.contextMenu([
                                {
                                    label: 'Copy',
                                    accelerator: 'Command+c',
                                    click: async () => $wire.copyColor('{{ $color->hex }}'),
                                },
                            ]);"
                        />

                @endforeach
            </flux:card>
        @endforeach
    </div>
</flux:accordion.item>

