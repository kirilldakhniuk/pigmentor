<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Color extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function palettes(): BelongsToMany
    {
        return $this->belongsToMany(Palette::class);
    }
}
