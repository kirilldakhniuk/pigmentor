<flux:card
    :$attributes
    size="sm"
    class="space-y-2 my-2"
>
    <div
        x-cloak
        x-data="{ isNotEditing: true }"
        class="flex justify-between items-center"
    >
        <flux:heading
            @dblclick="isNotEditing = false"
            x-show="isNotEditing"
        >
            {{ $palette->title }}
        </flux:heading>

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
            variant="subtle"
            class="hover:bg-transparent!"
            x-on:click="Native.contextMenu([
                {
                    label: 'Edit',
                    accelerator: 'Command+e',
                    click: async () => $wire.edit(),
                },
                {
                    label: 'Delete',
                    accelerator: 'Command+d',
                    click: async () => $wire.delete(),
                },
            ]);"
        />

    </div>

    <div wire:sort="moveColor" wire:sort:group="colors">
        @foreach($palette->colors as $color)
                <flux:button
                    wire:sort:item="{{ $palette->id }}:{{ $color->id }}"
                    wire:click="copyColor('{{ $color->hex }}')"
                    class="hover:scale-110"
                    style="background-color: {{ $color->hex }} !important"
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
                />

        @endforeach
    </div>
</flux:card>
