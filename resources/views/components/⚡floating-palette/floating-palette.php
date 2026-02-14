<?php

use App\Models\Palette;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Native\Desktop\Facades\Clipboard;
use Native\Desktop\Facades\Window;

new
#[Layout('components.layouts.floating')]
class extends Component
{
    public Palette $palette;

    public function mount(Palette $palette): void
    {
        $this->palette->load('colors');
    }

    public function copyColor(string $color): void
    {
        Clipboard::text($color);
    }

    public function closeWindow(): void
    {
        Window::close('floating-palette-'.$this->palette->id);
    }
};
