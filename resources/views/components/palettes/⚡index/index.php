<?php

use App\Models\Palette;
use App\Traits\ColorCopyable;
use Livewire\Attributes\Renderless;
use Livewire\Component;

new class extends Component
{
    use ColorCopyable;

    public $palettes = [];

    public function mount(): void
    {
        $this->loadPalettes();
    }

    public function edit($id)
    {
        return to_route('palettes.edit', $id);
    }

    public function delete($paletteId)
    {
        $palette = Palette::findOrFail($paletteId);

        $palette->delete();

        $this->loadPalettes();
    }

    public function loadPalettes()
    {
        $this->palettes = Palette::orderByDesc('position')->get();
    }

    #[Renderless]
    public function movePalette($item, $position)
    {
        $palette = Palette::findOrFail($item);

        $palette->move($position);
    }
};
