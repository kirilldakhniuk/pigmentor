<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<flux:header>
    <livewire:toolbar />
</flux:header>

<flux:main class="surface-base p-4">
    <livewire:color-history />

    <div class="my-6"></div>

    <livewire:palettes-view />
</flux:main>

<livewire:palette-panel />

