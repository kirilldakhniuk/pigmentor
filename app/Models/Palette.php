<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Palette extends Model
{
    use HasFactory;

    public function colors(): HasMany
    {
        return $this->hasMany(Color::class);
    }
}
