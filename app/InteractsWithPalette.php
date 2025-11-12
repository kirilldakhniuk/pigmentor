<?php

namespace App;

trait InteractsWithPalette
{
    public $hex = '';

    public $existingColors = [];

    public $fromColorHistory = [];

    public $fromAnotherPalette = [];

    public function pipetteColor($hex)
    {
        $this->form->pipetteColorToPalette($hex);
    }

    public function updatedHex($value)
    {
        $this->validate([
            'hex' => ['hex_color'],
        ]);

        $this->form->colors[] = $value;

        $this->reset('hex');
    }

    public function updatedFromAnotherPalette($value)
    {
        $this->form->colors[] = $value;

        $this->reset('fromAnotherPalette');
    }

    public function updatedFromColorHistory($value)
    {
        $this->form->colors[] = $value;

        $this->reset('fromColorHistory');
    }

    public function removeFromPalette($color)
    {
        $this->form->removeFromPalette($color);
    }
}
