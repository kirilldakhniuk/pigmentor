<?php

use App\Models\Color;
use App\Models\Palette;
use App\Traits\ColorCopyable;
use Livewire\Attributes\Renderless;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
    use ColorCopyable;

    protected $listeners = [
        'palette-refresh' => '$refresh'
    ];

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
        [$source, $value] = explode(':', $item, 2);

        if ($source === 'history') {
            $color = Color::firstOrCreate(['hex' => $value]);

            $color->addToPalette($this->palette, $position);

            $this->dispatch('remove-from-history', color: $value);
        } else {
            $sourcePalette = Palette::findOrFail($source);

            $color = $sourcePalette
                ->colors()
                ->withPivot('position')
                ->where('colors.id', $value)
                ->firstOrFail();

            $color->moveInto($this->palette, $position);
        }

        $this->dispatch('palette-refresh');
    }

    public function remove(Color $color)
    {
        $this->palette->colors()->detach($color->id);

        $this->dispatch('palette-refresh');
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
