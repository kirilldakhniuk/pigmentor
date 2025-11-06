<?php

namespace Database\Seeders;

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

        $nordPalette->colors()->createMany([
            ['hex' => '#2E3440'],
            ['hex' => '#3B4252'],
            ['hex' => '#434C5E'],
            ['hex' => '#4C566A'],
            ['hex' => '#D8DEE9'],
            ['hex' => '#E5E9F0'],
            ['hex' => '#ECEFF4'],
            ['hex' => '#8FBCBB'],
            ['hex' => '#88C0D0'],
            ['hex' => '#81A1C1'],
            ['hex' => '#5E81AC'],
            ['hex' => '#BF616A'],
            ['hex' => '#D08770'],
            ['hex' => '#EBCB8B'],
            ['hex' => '#A3BE8C'],
            ['hex' => '#B48EAD'],
        ]);
    }
}
