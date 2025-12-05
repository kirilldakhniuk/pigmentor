<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('color_palette', function (Blueprint $table) {
            $table
                ->unsignedInteger('position')
                ->default(0);
        });

        DB::table('color_palette')
            ->select('palette_id')
            ->distinct()
            ->pluck('palette_id')
            ->each(function ($paletteId) {
                $colors = DB::table('color_palette')
                    ->where('palette_id', $paletteId)
                    ->orderBy('position')
                    ->orderBy('color_id')
                    ->get(['color_id']);

                foreach ($colors as $index => $color) {
                    DB::table('color_palette')
                        ->where('palette_id', $paletteId)
                        ->where('color_id', $color->color_id)
                        ->update(['position' => $index + 1]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('color_palette', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
};
