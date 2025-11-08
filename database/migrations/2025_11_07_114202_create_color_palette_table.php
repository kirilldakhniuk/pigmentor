<?php

use App\Models\Color;
use App\Models\Palette;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('color_palette', function (Blueprint $table) {
            $table->foreignIdFor(Color::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(Palette::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->primary(['color_id', 'palette_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('color_palette');
    }
};
