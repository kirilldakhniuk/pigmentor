<?php

use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Native\Desktop\Facades\App;
use Native\Desktop\Facades\Settings;

new class extends Component
{
    public $openAtLogin;
    public $keepHistory;

    public function mount()
    {
        $this->openAtLogin = App::openAtLogin();

        $this->keepHistory = Settings::get('keep-history', config('app.keep_history'));
    }

    public function updatedOpenAtLogin($value)
    {
        App::openAtLogin($value);
    }

    public function updatedKeepHistory($value)
    {
        Settings::set('keep-history', $value);
    }

    public function sliderValueToLabel($value)
    {
        return match($value) {
            5 => 'Forever',
            4 => 'Year',
            3 => 'Month',
            2 => 'Week',
            1 => 'Day'
        };
    }

    public function eraseHistory()
    {
        Cache::pull('picks-history');
    }
};
