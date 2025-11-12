<?php

use App\InteractsWithPalette;
use App\Livewire\Forms\PaletteForm;
use App\Models\Color;
use App\Models\Palette;
use Livewire\Component;

new class extends Component {
    use InteractsWithPalette;

    public PaletteForm $form;

    public function mount(Palette $palette): void
    {
        $this->form->setPalette($palette);

        $this->existingColors = Color::all()
            ->pluck('hex')
            ->toArray();
    }

    public function save()
    {
        $this->form->update();

        $this->redirectRoute('home');
    }
};
