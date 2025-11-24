<?php

namespace App\Traits;

use Native\Desktop\Facades\Clipboard;
use Native\Desktop\Facades\MenuBar;

trait ColorCopyable
{
    public function copyColor($color)
    {
        Clipboard::text($color);

        MenuBar::hide();
    }
}
