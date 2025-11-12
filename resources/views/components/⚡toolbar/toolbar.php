<?php

use Livewire\Component;

new class extends Component
{
    public $history = [];

    public function mount(): void
    {
        $this->history = Cache::get('picks-history');
    }

    public function pickColor($color): void
    {
        Clipboard::text($color);

        $this->history[] = $color;

        Cache::put('picks-history', $this->history, now()->addWeek());

        $this->dispatch('color-picked', color: $color);
    }
};
