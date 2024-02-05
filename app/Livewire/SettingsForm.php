<?php

namespace App\Livewire;

use App\Livewire\Forms\GeneralSettingsForm;
use App\Services\CrudServices\SettingsService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class SettingsForm extends Component
{
    public string $activeTab = 'general_settings';

    public GeneralSettingsForm $generalSettingsForm;


    public function mount()
    {
        $this->generalSettingsForm->getGeneralSettings();
    }

    public function submit(): void
    {
        $this->generalSettingsForm->updateGeneralSettings();
        $this->swal(icon: 'success', title: 'Success', message: __('app.settings.update_done'));
    }

    private function swal($icon, $title, $message): void
    {
        $this->dispatch('swal', [
            'icon' => $icon,
            'title' => $title,
            'text' => $message,
        ]);
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.settings-form');
    }
}
