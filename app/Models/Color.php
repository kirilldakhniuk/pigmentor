<?php

namespace App\Models;

use App\Traits\MovesBetweenPalettes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Color extends Model
{
    use HasFactory, MovesBetweenPalettes;

    public $timestamps = false;

    public function palettes(): BelongsToMany
    {
        return $this
            ->belongsToMany(Palette::class)
            ->using(ColorPalette::class)
            ->withPivot('position')
            ->orderBy('color_palette.position');
    }
}
