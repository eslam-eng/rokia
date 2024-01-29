<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;

class UsersSearch extends Component
{
    public string $search = '';

    public string $name = '';

    public Collection $options;

    public mixed $selected;

    public string $title;

    public ?int $user_type = null;


    public function __construct()
    {
        $this->options = collect();
    }

    public function updatedSelected()
    {
        $this->dispatch('onUserChange',$this->selected);
        $this->skipRender();
    }

    public function render()
    {
        return view('livewire.users-search');
    }
}
