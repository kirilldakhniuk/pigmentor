<flux:modal wire:model.self="showPanel" flyout class="space-y-4">
    @if($isCreateMode)
        <div class="flyout-header">
            <flux:heading size="lg">New Palette</flux:heading>
            <flux:subheading>Create a new color palette</flux:subheading>
        </div>

        <flux:input
            wire:model="title"
            wire:keydown.enter="createPalette"
            label="Name"
            placeholder="Palette name"
            size="sm"
        />

        <div class="flex pt-2">
            <flux:spacer />

            <flux:button
                wire:click="createPalette"
                size="sm"
            >
                Create Palette
            </flux:button>
        </div>
    @elseif($palette)
        <div class="flyout-header">
            <flux:heading size="lg">Edit Palette</flux:heading>
            <flux:subheading>Manage colors and settings</flux:subheading>
        </div>

        <div class="flyout-section">
            <flux:input
                wire:model.blur="title"
                label="Name"
                placeholder="Palette name"
                size="sm"
            />
        </div>

        <div class="flyout-section">
            <flux:label class="mb-2">Colors</flux:label>
            @if($palette->colors->count() > 0)
                <div class="flex flex-wrap gap-2">
                    @foreach($palette->colors as $color)
                        <button
                            type="button"
                            wire:click="removeColor({{ $color->id }})"
                            class="color-swatch w-8 h-8 rounded-lg border-0 relative group"
                            style="background-color: {{ $color->hex }}"
                            title="Click to remove"
                        >
                            <span class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 bg-black/30 rounded-lg transition-fast">
                                <flux:icon.x-mark class="size-3 text-white" />
                            </span>
                        </button>
                    @endforeach
                </div>
            @else
                <flux:subheading>No colors yet</flux:subheading>
            @endif
        </div>

        <div class="flyout-section">
            <flux:label class="mb-2">Add Color</flux:label>
            <div class="flex gap-2">
                <flux:button
                    @click="new EyeDropper().open().then(r => $wire.addColor(r.sRGBHex)).catch(e => {})"
                    icon="pipette"
                    variant="ghost"
                    size="sm"
                    square
                />
                <flux:input
                    wire:model="newHex"
                    wire:keydown.enter="addColorFromHex"
                    placeholder="#000000"
                    size="sm"
                    class="flex-1"
                />
                <flux:button
                    wire:click="addColorFromHex"
                    size="sm"
                >
                    Add
                </flux:button>
            </div>
        </div>
    @else
        <div class="flex items-center justify-center py-8">
            <flux:subheading>Loading...</flux:subheading>
        </div>
    @endif
</flux:modal>
