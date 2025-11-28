<?php

namespace App\Providers;

use App\Events\AppSettingsClicked;
use Native\Desktop\Contracts\ProvidesPhpIni;
use Native\Desktop\Facades\Menu;
use Native\Desktop\Facades\MenuBar;

class NativeAppServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {
        MenuBar::create()
            ->withContextMenu(
                Menu::make(
                    Menu::label('Settings')
                        ->hotkey('Cmd+,')
                        ->event(AppSettingsClicked::class),
                    Menu::link('https://github.com/kirilldakhniuk/pigmentor/issues/new', 'Submit an issue')
                        ->openInBrowser(),
                    Menu::separator(),
                    Menu::quit('Quit')
                )
            )
            ->alwaysOnTop(app()->environment('local'))
            ->icon(public_path('menuBarIconTemplate.png'))
            ->height(600);

    }

    /**
     * Return an array of php.ini directives to be set.
     */
    public function phpIni(): array
    {
        return [
        ];
    }
}
