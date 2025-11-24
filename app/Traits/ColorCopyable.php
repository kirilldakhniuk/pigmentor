<?php

namespace App\Traits;

use Native\Desktop\Facades\App;
use Native\Desktop\Facades\Clipboard;

trait ColorCopyable
{
    public function copyColor($color)
    {
        Clipboard::text($color);

        App::hide();
    }
}
