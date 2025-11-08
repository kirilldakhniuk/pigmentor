<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Palette extends Model
{
    use HasFactory;

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class);
    }
}
