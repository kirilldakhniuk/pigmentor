<div
    {{ $attributes->class(['card p-4 my-3']) }}
>
    <div
        x-cloak
        x-data="{ isNotEditing: true }"
        class="flex justify-between items-center mb-3"
    >
        <h3
            @dblclick="isNotEditing = false"
            x-show="isNotEditing"
            class="heading-section text-sm"
        >
            {{ $palette->title }}
        </h3>

        <form
            @click.outside="isNotEditing = true"
            x-show="!isNotEditing"
            wire:submit.prevent="save"
        >
            <flux:input
                wire:model="title"
                @keyup.enter="$el.form.submit()"
                x-bind:disabled="isNotEditing"
                class:input="w-full bg-transparent"
                size="sm"
                value="{{ $palette->title }}"
            />
        </form>

        <flux:button
            icon="ellipsis-horizontal"
            variant="ghost"
            size="sm"
            class="opacity-50 hover:opacity-100 transition-fast"
            x-on:click="Native.contextMenu([
                {
                    label: 'Edit',
                    accelerator: 'Command+e',
                    click: () => $dispatch('open-palette-panel', { id: {{ $palette->id }} }),
                },
                {
                    label: 'Float',
                    accelerator: 'Command+f',
                    click: () => $wire.openFloatingWindow(),
                },
                {
                    label: 'Delete',
                    accelerator: 'Command+d',
                    click: () => Flux.modal('confirm-delete-{{ $palette->id }}').show(),
                },
            ]);"
        />
    </div>

    <flux:modal name="confirm-delete-{{ $palette->id }}" class="max-w-xs">
        <div class="space-y-4">
            <div>
                <flux:heading size="lg">Delete "{{ $palette->title }}"?</flux:heading>
                <flux:text class="mt-2">This action cannot be undone. The palette will be permanently removed.</flux:text>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <flux:modal.close>
                    <flux:button variant="ghost" size="sm">Cancel</flux:button>
                </flux:modal.close>
                <flux:button wire:click="delete" variant="danger" size="sm">
                    Delete Palette
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <div wire:sort="moveColor" wire:sort:group="colors" class="flex flex-wrap gap-2">
        @foreach($palette->colors as $color)
            <button
                type="button"
                wire:sort:item="{{ $palette->id }}:{{ $color->id }}"
                wire:click="copyColor('{{ $color->hex }}')"
                class="color-swatch w-8 h-8 rounded-lg cursor-pointer border-0"
                style="background-color: {{ $color->hex }}"
                x-on:contextmenu="Native.contextMenu([
                    {
                        label: 'Copy',
                        accelerator: 'Command+c',
                        click: async () => $wire.copyColor('{{ $color->hex }}'),
                    },
                    {
                        label: 'Delete',
                        accelerator: 'Command+Backspace',
                        click: async () => $wire.remove('{{ $color->id }}'),
                    },
                ]);"
            ></button>
        @endforeach
    </div>
</div>
