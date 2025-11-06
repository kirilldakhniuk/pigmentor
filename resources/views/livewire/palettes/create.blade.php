<?php

use App\Models\Palette;
use function Livewire\Volt\{layout, state};

state(['name']);

layout('components.layouts.app');

$save = function () {
    $this->validate([
        'name' => [
            'required',
            'string',
            'min:3',
        ],
    ]);

    Palette::create([
        'name' => $this->name,
    ]);

    $this->redirectRoute('home');
};
?>

<div>
    <flux:header>
        <flux:button href="{{ route('home') }}">Back</flux:button>
    </flux:header>

    <flux:main>
        <form wire:submit="save" class="space-y-6">
            <flux:input label="{{ __('Name') }}" wire:model="name"></flux:input>
            <flux:button type="submit" class="cursor-pointer w-full">{{ __('Create') }}</flux:button>
        </form>
    </flux:main>
</div>
