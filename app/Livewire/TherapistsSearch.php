<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;

class TherapistsSearch extends Component
{
    public string $search = '';

    public string $name = '';

    public Collection $options;

    public mixed $selected;

    public string $title;


    public function __construct()
    {
        $this->options = collect();
    }

    public function updatedSelected()
    {
        $this->dispatch('onTherapistChange',$this->selected);
        $this->skipRender();
    }

    public function render()
    {
        return view('livewire.therapists-search');
    }
}
