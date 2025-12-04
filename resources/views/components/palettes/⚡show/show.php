<?php

use App\Models\Palette;
use Livewire\Attributes\Renderless;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
    public Palette $palette;

    #[Validate('required')]
    public $title = '';

    public function mount()
    {
        $this->title = $this->palette->title;
    }

    #[Renderless]
    public function save()
    {
        $this->validate();

        $this->palette->update([
            'title' => $this->title,
        ]);
    }

    public function edit()
    {
        return to_route('palettes.edit', $this->palette->id);
    }

    public function delete()
    {
        $this->palette->delete();

        $this->dispatch('load-palettes');
    }
};
