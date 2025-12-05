<div class="flex justify-between w-full mt-6">
    <flux:button
        @click="new EyeDropper().open().then(r => $wire.pickColor(r.sRGBHex)).catch(e => {})"
        class="rounded-xl"
        variant="ghost"
        size="sm"
        icon="pipette"
        square
    >
    </flux:button>

    <flux:button href="{{ route('palettes.create') }}"
        data-test="add-new-palette"
        variant="primary"
        color="blue"
        size="sm"
        class="rounded-xl"
    >
        {{ __('Add New Palette') }}
    </flux:button>
</div>
