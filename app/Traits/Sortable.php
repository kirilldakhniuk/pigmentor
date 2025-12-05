<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait Sortable
{
    public static function bootSortable()
    {
        static::creating(function ($model) {
            $model->position = $model->max('position') + 1;
        });

        static::deleting(function ($model) {
            $model->move(9999);
        });
    }

    public function move($position)
    {
        $position = $position + 1;

        DB::transaction(function () use ($position) {
            $current = $this->position;

            if ($current == $position) {
                return;
            }

            $direction = $position < $current ? 'up' : 'down';

            if ($direction === 'up') {
                $this->whereBetween('position', [$position, $current - 1])
                    ->where('id', '!=', $this->id)
                    ->increment('position');
            } else {
                $this->whereBetween('position', [$current + 1, $position])
                    ->where('id', '!=', $this->id)
                    ->decrement('position');
            }

            $this->position = $position;
            $this->save();
        });
    }
}
