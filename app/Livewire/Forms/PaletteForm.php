<?php

namespace App\Livewire\Forms;

use App\Models\Color;
use App\Models\Palette;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PaletteForm extends Form
{
    public ?Palette $palette;

    #[Validate('required')]
    public string $title = '';

    public array $colors = [];

    public function setPalette(Palette $palette): void
    {
        $this->palette = $palette;
        $this->title = $palette->title;
        $this->colors = $palette->colors->pluck('hex')->toArray();
    }

    public function store(): void
    {
        $this->validate();

        $palette = Palette::create(['title' => $this->title]);

        $this->syncColorsForPalette($palette);
    }

    public function update(): void
    {
        $this->validate();

        $this->palette->update([
            'title' => $this->title,
        ]);

        $this->syncColorsForPalette($this->palette);
    }

    public function pipetteColorToPalette(string $hex): void
    {
        $this->colors[] = $hex;
        $this->hex = '';
    }

    public function removeFromPalette(string $hexToRemove): void
    {
        $this->colors = array_values(array_filter($this->colors, fn ($c) => $c !== $hexToRemove));
    }

    public function syncColorsForPalette(Palette $palette): void
    {
        if ($this->colors) {
            Color::upsert(
                collect($this->colors)->map(fn ($hex) => ['hex' => $hex])->toArray(),
                ['hex']
            );

            $colors = Color::whereIn('hex', $this->colors)->pluck('id');

            $palette->colors()->sync($colors);
        }
    }
}
