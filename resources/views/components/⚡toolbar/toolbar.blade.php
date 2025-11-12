<div class="flex justify-between w-full">
    <flux:button
        x-data
        @click="new EyeDropper().open().then(r => $wire.pickColor(r.sRGBHex)).catch(e => {})"
        class="cursor-pointer"
        icon="pipette"
        square
    />

    <flux:button href="{{ route('palettes.create') }}" data-test="add-new-palette" class="cursor-pointer" icon="plus">
        {{ __('Add New Palette') }}
    </flux:button>
</div>