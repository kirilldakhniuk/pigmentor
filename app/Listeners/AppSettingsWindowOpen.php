<?php

namespace App\Listeners;

use App\Events\AppSettingsClicked;
use Native\Desktop\Facades\Window;

class AppSettingsWindowOpen
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AppSettingsClicked $event): void
    {
        Window::open('app-settings')
            ->titleBarHidden()
            ->resizable(false)
            ->movable(true)
            ->width(700)
            ->height(700)
            ->url(route('app.settings'));
    }
}
