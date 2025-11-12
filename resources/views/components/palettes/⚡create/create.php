<?php

use App\InteractsWithPalette;
use App\Livewire\Forms\PaletteForm;
use App\Models\Color;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component {
    use InteractsWithPalette;

    public PaletteForm $form;

    public function mount()
    {
        $this->existingColors = Color::all()
            ->pluck('hex')
            ->toArray();
    }

    public function save()
    {
        $this->form->store();

        $this->redirectRoute('home');
    }
};
