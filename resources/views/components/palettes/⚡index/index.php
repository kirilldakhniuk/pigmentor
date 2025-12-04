<?php

use App\Models\Palette;
use App\Traits\ColorCopyable;
use Livewire\Attributes\On;
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

    #[On('load-palettes')]
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
