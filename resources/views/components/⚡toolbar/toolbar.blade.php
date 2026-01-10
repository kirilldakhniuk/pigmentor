<div class="flex justify-between items-center w-full py-3 px-1">
    <flux:button
        @click="new EyeDropper().open().then(r => $wire.pickColor(r.sRGBHex)).catch(e => {})"
        class="rounded-xl transition-smooth press-effect hover:scale-105"
        variant="ghost"
        size="sm"
        icon="pipette"
        square
    >
    </flux:button>

    <flux:button
        x-on:click="$dispatch('create-palette-panel')"
        data-test="add-new-palette"
        variant="primary"
        size="sm"
        class="rounded-xl transition-smooth press-effect"
    >
        {{ __('New Palette') }}
    </flux:button>
</div>
