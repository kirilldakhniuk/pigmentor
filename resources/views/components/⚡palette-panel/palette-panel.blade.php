<div
    x-data="{ open: false }"
    x-on:open-palette-panel.window="open = true; $wire.loadPalette($event.detail.id)"
    x-on:create-palette-panel.window="open = true; $wire.createMode()"
    x-on:close-palette-panel.window="open = false"
    x-on:keydown.escape.window="open = false"
>
    <div
        class="slide-panel-backdrop"
        :class="{ 'is-open': open }"
        @click="open = false"
    ></div>

    <div
        class="slide-panel"
        :class="{ 'is-open': open }"
    >
        @if($isCreateMode)
            <div class="slide-panel-header">
                <span class="slide-panel-title">New Palette</span>
                <button
                    class="slide-panel-close"
                    @click="open = false"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <div class="slide-panel-body space-y-6">
                <div>
                    <label class="heading-label block mb-2">Name</label>
                    <flux:input
                        wire:model="title"
                        placeholder="Palette name"
                        size="sm"
                        autofocus
                    />
                </div>
            </div>

            <div class="slide-panel-footer">
                <flux:button
                    wire:click="createPalette"
                    variant="primary"
                    size="sm"
                    class="w-full"
                >
                    Create Palette
                </flux:button>
            </div>
        @elseif($palette)
            <div class="slide-panel-header">
                <span class="slide-panel-title">Edit Palette</span>
                <button
                    class="slide-panel-close"
                    @click="open = false"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <div class="slide-panel-body space-y-6">
                <div>
                    <label class="heading-label block mb-2">Name</label>
                    <flux:input
                        wire:model.blur="title"
                        placeholder="Palette name"
                        size="sm"
                    />
                </div>

                <div>
                    <label class="heading-label block mb-2">Colors</label>
                    <div class="card-refined p-3">
                        @if($palette->colors->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($palette->colors as $color)
                                    <button
                                        type="button"
                                        wire:click="removeColor({{ $color->id }})"
                                        class="color-swatch w-8 h-8 rounded-lg cursor-pointer border-0 relative group"
                                        style="background-color: {{ $color->hex }}"
                                        title="Click to remove"
                                    >
                                        <span class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 bg-black/30 rounded-lg transition-fast">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                            </svg>
                                        </span>
                                    </button>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted text-sm">No colors yet</p>
                        @endif
                    </div>
                </div>

                <div>
                    <label class="heading-label block mb-2">Add Color</label>
                    <div class="flex gap-2">
                        <flux:button
                            @click="new EyeDropper().open().then(r => $wire.addColor(r.sRGBHex)).catch(e => {})"
                            icon="pipette"
                            size="sm"
                            variant="ghost"
                            class="rounded-lg"
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
                            variant="primary"
                            class="rounded-lg"
                        >
                            Add
                        </flux:button>
                    </div>
                </div>
            </div>

            <div class="slide-panel-footer">
                <flux:button
                    wire:click="deletePalette"
                    variant="ghost"
                    size="sm"
                    class="w-full text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950"
                >
                    Delete Palette
                </flux:button>
            </div>
        @else
            <div class="slide-panel-body flex items-center justify-center">
                <p class="text-muted">Loading...</p>
            </div>
        @endif
    </div>
</div>
