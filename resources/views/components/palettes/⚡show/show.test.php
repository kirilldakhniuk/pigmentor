<?php

use App\Models\Color;
use App\Models\Palette;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;

test('a color can move into another palette at the requested position', function () {
    [$source, $target] = Palette::factory()
        ->count(2)
        ->create();

    [$first, $second, $third] = Color::factory()
        ->count(3)
        ->create();

    $source->colors()->attach($first->id, ['position' => 1]);
    $source->colors()->attach($second->id, ['position' => 2]);

    $target->colors()->attach($third->id, ['position' => 1]);

    Livewire::test('palettes.show', ['palette' => $target])
        ->call('moveColor', $first->id, 0);

    expect(
        DB::table('color_palette')
            ->where('palette_id', $source->id)
            ->orderBy('position')
            ->pluck('color_id')
            ->toArray()
    )->toBe([$second->id]);

    expect(
        DB::table('color_palette')
            ->where('palette_id', $target->id)
            ->orderBy('position')
            ->get(['color_id', 'position'])
            ->map(fn ($row) => [$row->color_id, $row->position])
            ->toArray()
    )->toBe([
        [$first->id, 1],
        [$third->id, 2],
    ]);
});
