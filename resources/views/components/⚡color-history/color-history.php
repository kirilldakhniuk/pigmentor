<?php

use App\Traits\ColorCopyable;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    use ColorCopyable;

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

    public function remove($color)
    {
        $this->setHistory(array_values(array_filter($this->history, fn ($c) => $c !== $color)));
    }
};
