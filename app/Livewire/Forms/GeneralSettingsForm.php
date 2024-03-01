<?php

namespace App\Livewire\Forms;

use App\Models\Settings\GeneralSettings;
use App\Models\Settings\SalesInvoiceSetting;
use App\Services\Settings\SettingsService;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Form;

class GeneralSettingsForm extends Form
{
    #[Validate('required|image')]
    public ?string $app_logo = null;

    #[Validate('required|string')]
    public ?string $about_us = null;

    #[Validate('required|string')]
    public ?string $privacy_condition =null;
    #[Validate('required|string')]

    public ?string $support_phone = null;

    private ?SettingsService $settingsService;
    private ?GeneralSettings $generalSettings;


    public function __construct(Component $component, $propertyName)
    {
        parent::__construct($component, $propertyName);
        $this->settingsService = app(SettingsService::class);
        $this->generalSettings = app(GeneralSettings::class);
    }

    public function getGeneralSettings(): void
    {
        $this->app_logo = $this->generalSettings->app_logo;
        $this->about_us = $this->generalSettings->about_us;
        $this->privacy_condition = $this->generalSettings->privacy_condition;
        $this->support_phone = $this->generalSettings->support_phone;
    }

    public function updateGeneralSettings(): void
    {
        $this->settingsService->updateGeneralSettings(generalSettingsData: $this->all());
    }

    public function rules(): array
    {
        return [
          'app_logo'=>'nullable|image',
          'about_us'=>'nullable|string',
          'privacy_condition'=>'nullable|string',
          'support_phone'=>'nullable|string',
        ];
    }

}
