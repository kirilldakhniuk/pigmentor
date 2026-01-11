<div class="flex justify-between items-center w-full py-3 px-1 mt-4">
    <flux:button
        @click="new EyeDropper().open().then(r => $wire.pickColor(r.sRGBHex)).catch(e => {})"
        variant="ghost"
        size="sm"
        icon="pipette"
        square
    />

    <flux:button
        x-on:click="$dispatch('create-palette-panel')"
        data-test="add-new-palette"
        size="sm"
    >
        {{ __('New Palette') }}
    </flux:button>
</div>
