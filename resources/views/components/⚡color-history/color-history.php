<?php

use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;
use Native\Desktop\Facades\Clipboard;
use Native\Desktop\Facades\MenuBar;

new class extends Component
{
    public $history = [];

    public function mount()
    {
        $this->history = Cache::get('picks-history', []);
    }

    public function setHistory(array $history)
    {
        $this->history = $history;

        Cache::set('picks-history', $history);
    }

    #[On('color-picked')]
    public function addToHistory(string $color)
    {
        $this->setHistory(array_merge($this->history, [$color]));
    }

    public function copy($color)
    {
        Clipboard::text($color);

        MenuBar::hide();
    }

    public function remove($color)
    {
        $this->setHistory(array_values(array_filter($this->history, fn ($c) => $c !== $color)));
    }
};
