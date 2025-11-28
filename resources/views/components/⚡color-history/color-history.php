<?php

use App\Events\EraseHistory;
use App\Traits\ColorCopyable;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;
use Native\Desktop\Events\Settings\SettingChanged;
use Native\Desktop\Facades\Settings;

new class extends Component
{
    use ColorCopyable;

    protected $listeners = [
        'native:'.SettingChanged::class => '$refresh',
    ];

    public $history = [];

    public function mount()
    {
        $this->setHistory(Cache::pull('picks-history', []));
    }

    public function setHistory(array $history)
    {
        $this->history = $history;

        Cache::set(
            'picks-history',
            $history,
            $this->setHistoryInterval()
        );
    }

    public function setHistoryInterval()
    {
        return match(Settings::get('keep-history', config('app.keep_history'))) {
            5 => null,
            4 => 31557600,
            3 => 2592000,
            2 => 604800,
            1 => 86400
        };
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
