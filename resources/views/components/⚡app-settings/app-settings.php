<?php

use Livewire\Component;
use Native\Desktop\Facades\App;

new class extends Component
{
    public $isOpenAtLogin;
    public $keepHistory;

    public function mount()
    {
        $this->isOpenAtLogin = App::openAtLogin();
    }

    public function updatedOpenAtLogin($value)
    {
        App::openAtLogin($value);
    }
};
