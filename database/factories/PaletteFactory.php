<?php

namespace Database\Factories;

use App\Models\Palette;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaletteFactory extends Factory
{
    protected $model = Palette::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->name(),
        ];
    }
}
