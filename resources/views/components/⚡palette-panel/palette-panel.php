<?php

use App\Models\Color;
use App\Models\Palette;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public ?Palette $palette = null;
    public string $title = '';
    public string $newHex = '';
    public bool $isCreateMode = false;
    public bool $showPanel = false;

    #[On('open-palette-panel')]
    public function loadPalette(int $id): void
    {
        $this->isCreateMode = false;
        $this->palette = Palette::with('colors')->find($id);
        $this->title = $this->palette?->title ?? '';
        $this->showPanel = true;
    }

    #[On('create-palette-panel')]
    public function createMode(): void
    {
        $this->isCreateMode = true;
        $this->palette = null;
        $this->title = '';
        $this->newHex = '';
        $this->showPanel = true;
    }

    public function createPalette(): void
    {
        if (empty($this->title)) {
            return;
        }

        $this->palette = Palette::create(['title' => $this->title]);
        $this->isCreateMode = false;
        $this->showPanel = false;
        $this->dispatch('load-palettes');
    }

    public function updatedTitle(): void
    {
        if ($this->palette && $this->title && !$this->isCreateMode) {
            $this->palette->update(['title' => $this->title]);
            $this->dispatch('palette-refresh');
        }
    }

    public function addColor(string $hex): void
    {
        if (! $this->palette) {
            return;
        }

        $color = Color::firstOrCreate(['hex' => $hex]);
        $color->addToPalette($this->palette, PHP_INT_MAX);

        $this->palette->load('colors');
        $this->dispatch('palette-refresh');
    }

    public function addColorFromHex(): void
    {
        if (empty($this->newHex)) {
            return;
        }

        $this->addColor($this->newHex);
        $this->newHex = '';
    }

    public function removeColor(int $colorId): void
    {
        if (! $this->palette) {
            return;
        }

        $this->palette->colors()->detach($colorId);
        $this->palette->load('colors');
        $this->dispatch('palette-refresh');
    }

    public function deletePalette(): void
    {
        if (! $this->palette) {
            return;
        }

        $this->palette->delete();
        $this->palette = null;
        $this->showPanel = false;
        $this->dispatch('load-palettes');
    }

    public function closePanel(): void
    {
        $this->showPanel = false;
    }
};
