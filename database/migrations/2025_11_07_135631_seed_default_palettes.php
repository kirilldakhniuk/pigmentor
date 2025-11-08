<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('palettes')->insert([
            ['id' => 1, 'name' => 'Nord', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('colors')->insert([
            ['id' => 1, 'hex' => '#2e3440'],
            ['id' => 2, 'hex' => '#3b4252'],
            ['id' => 3, 'hex' => '#434c5e'],
            ['id' => 4, 'hex' => '#4c566a'],
            ['id' => 5, 'hex' => '#d8dee9'],
            ['id' => 6, 'hex' => '#e5e9f0'],
            ['id' => 7, 'hex' => '#eceff4'],
            ['id' => 8, 'hex' => '#8fbcbb'],
            ['id' => 9, 'hex' => '#88c0d0'],
            ['id' => 10, 'hex' => '#81a1c1'],
            ['id' => 11, 'hex' => '#5e81ac'],
            ['id' => 12, 'hex' => '#bf616a'],
            ['id' => 13, 'hex' => '#d08770'],
            ['id' => 14, 'hex' => '#ebcb8b'],
            ['id' => 15, 'hex' => '#a3be8c'],
            ['id' => 16, 'hex' => '#b48ead'],
        ]);

        DB::table('color_palette')->insert(
            collect(range(1, 16))->map(fn ($colorId) => [
                'palette_id' => 1,
                'color_id' => $colorId,
            ])->toArray()
        );
    }
};
