<?php

namespace App\Traits;

use App\Models\ColorPalette;
use App\Models\Palette;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

trait MovesBetweenPalettes
{
    public static function bootMovesBetweenPalettes(): void
    {
        ColorPalette::creating(function (ColorPalette $pivot): void {
            $pivot->position = ColorPalette::query()
                ->where('palette_id', $pivot->palette_id)
                ->max('position') + 1;
        });
    }

    public function moveInto(Palette $palette, int $position): void
    {
        DB::transaction(function () use ($palette, $position) {
            $pivotPaletteId = Arr::get($this, 'pivot.palette_id');
            $pivotPosition = Arr::get($this, 'pivot.position');

            if (! $pivotPaletteId || $pivotPosition === null) {
                $pivot = ColorPalette::query()
                    ->where('color_id', $this->id)
                    ->firstOrFail(['palette_id', 'position']);

                $pivotPaletteId = $pivot->palette_id;
                $pivotPosition = $pivot->position;
            }

            $position = max(0, $position);

            $targetPositions = ColorPalette::query()
                ->where('palette_id', $palette->id)
                ->lockForUpdate()
                ->orderBy('position')
                ->pluck('position');

            $position = min($position, $targetPositions->count());
            $position = $position + 1;

            if ($pivotPaletteId === $palette->id) {
                $this->moveWithinPalette($position);

                return;
            }

            ColorPalette::query()
                ->where('palette_id', $pivotPaletteId)
                ->where('position', '>', $pivotPosition)
                ->decrement('position');

            ColorPalette::query()
                ->where('palette_id', $palette->id)
                ->where('position', '>=', $position)
                ->increment('position');

            ColorPalette::query()
                ->where('palette_id', $pivotPaletteId)
                ->where('color_id', $this->id)
                ->delete();

            ColorPalette::query()->updateOrCreate(
                [
                    'palette_id' => $palette->id,
                    'color_id' => $this->id,
                ],
                [
                    'position' => $position,
                ]
            );

            if ($this->pivot) {
                $this->pivot->palette_id = $palette->id;
                $this->pivot->position = $position;
            }
        });
    }

    private function moveWithinPalette(int $position): void
    {
        $current = Arr::get($this, 'pivot.position');

        if ($current == $position) {
            return;
        }

        $direction = $position < $current ? 'up' : 'down';

        if ($direction === 'up') {
            ColorPalette::query()
                ->where('palette_id', Arr::get($this, 'pivot.palette_id'))
                ->lockForUpdate()
                ->whereBetween('position', [$position, $current - 1])
                ->increment('position');
        } else {
            ColorPalette::query()
                ->where('palette_id', Arr::get($this, 'pivot.palette_id'))
                ->lockForUpdate()
                ->whereBetween('position', [$current + 1, $position])
                ->decrement('position');
        }

        ColorPalette::query()
            ->where('palette_id', Arr::get($this, 'pivot.palette_id'))
            ->where('color_id', $this->id)
            ->update(['position' => $position]);

        if ($this->pivot) {
            $this->pivot->position = $position;
        }
    }
}
