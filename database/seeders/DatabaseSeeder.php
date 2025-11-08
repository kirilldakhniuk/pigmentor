<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Palette;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $nordPalette = Palette::factory()->create([
            'name' => 'Nord',
        ]);

        Color::upsert([
            ['hex' => '#2e3440'],
            ['hex' => '#3b4252'],
            ['hex' => '#434c5e'],
            ['hex' => '#4c566a'],
            ['hex' => '#d8dee9'],
            ['hex' => '#e5e9f0'],
            ['hex' => '#eceff4'],
            ['hex' => '#8fbcbb'],
            ['hex' => '#88c0d0'],
            ['hex' => '#81a1c1'],
            ['hex' => '#5e81ac'],
            ['hex' => '#bf616a'],
            ['hex' => '#d08770'],
            ['hex' => '#ebcb8b'],
            ['hex' => '#a3be8c'],
            ['hex' => '#b48ead'],
        ], uniqueBy: 'hex');

        Color::each(fn ($color) => $nordPalette->colors()->attach($color));
    }
}
