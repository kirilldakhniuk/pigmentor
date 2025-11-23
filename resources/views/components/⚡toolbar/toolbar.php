<?php

use Livewire\Component;
use Native\Desktop\Facades\Clipboard;

new class extends Component
{
    public function pickColor($color): void
    {
        Clipboard::text($color);

        $this->dispatch('color-picked', color: $color);
    }
};
