<div class="p-2 min-h-screen surface-base">
    <div
        class="draggable-header cursor-move mb-3 flex justify-center"
        x-on:contextmenu="Native.contextMenu([
            {
                label: 'Close',
                accelerator: 'Command+w',
                click: () => $wire.closeWindow(),
            },
        ])"
    >
        <flux:icon.bars-2 class="size-4 text-zinc-400" />
    </div>

    <div class="flex flex-col gap-2 items-center">
        @foreach($palette->colors as $color)
            <button
                wire:key="floating-{{ $color->id }}"
                wire:click="copyColor('{{ $color->hex }}').then(() => window.blur())"
                class="color-swatch size-10 rounded-lg border-0"
                style="background-color: {{ $color->hex }}"
                title="{{ $color->hex }}"
            ></button>
        @endforeach
    </div>
</div>
