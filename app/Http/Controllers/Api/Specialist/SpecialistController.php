<?php

namespace App\Http\Controllers\Api\Specialist;

use App\Enums\ActivationStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Specialist\SpecialistResource;
use App\Services\Specialist\SpecialistService;

class SpecialistController extends Controller
{
    public function __construct(protected SpecialistService $specialistService)
    {
    }

    public function __invoke()
    {
        $filters = ['status' => ActivationStatus::ACTIVE->value];
        $specialists = $this->specialistService->getAll(filters: $filters);
        return SpecialistResource::collection($specialists);
    }


}
