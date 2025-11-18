<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('palettes', function (Blueprint $table) {
            $table->renameColumn('name', 'title');

            $table
                ->integer('position')
                ->nullable()
                ->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('palettes', function (Blueprint $table) {
            $table->renameColumn('title', 'name');

            $table->dropIfExists('position');
        });
    }
};
