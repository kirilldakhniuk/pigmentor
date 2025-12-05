<?php

use App\Models\ColorPalette;
use App\Models\Palette;
use App\Traits\ColorCopyable;
use Livewire\Attributes\Renderless;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
    use ColorCopyable;

    public Palette $palette;

    #[Validate('required')]
    public $title = '';

    public function mount(Palette $palette): void
    {
        $this->palette = $palette->load('colors');

        $this->title = $this->palette->title;
    }

    #[Renderless]
    public function save()
    {
        $this->validate();

        $this->palette->update([
            'title' => $this->title,
        ]);
    }

    #[Renderless]
    public function moveColor($item, $position)
    {
        [$sourcePaletteId, $colorId] = explode(':', $item, 2);

        $sourcePalette = Palette::findOrFail($sourcePaletteId);

        $color = $sourcePalette
            ->colors()
            ->withPivot('position')
            ->where('colors.id', $colorId)
            ->firstOrFail();

        $color->moveInto($this->palette, $position);
    }

    public function edit()
    {
        return to_route('palettes.edit', $this->palette->id);
    }

    public function delete()
    {
        $this->palette->delete();

        $this->dispatch('load-palettes');
    }
};
