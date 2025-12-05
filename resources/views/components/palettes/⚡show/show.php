<?php

use App\Models\ColorPalette;
use App\Models\Palette;
use Livewire\Attributes\Renderless;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
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
        $pivot = ColorPalette::query()
            ->where('color_id', $item)
            ->firstOrFail(['palette_id', 'position']);

        $sourcePalette = Palette::findOrFail($pivot->palette_id);

        $color = $sourcePalette
            ->colors()
            ->withPivot('position')
            ->where('colors.id', $item)
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
