<?php

namespace App\Http\Controllers\Api\Slider;

use App\Enums\ActivationStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\SlidersResource;
use App\Services\SliderService;

class SliderController extends Controller
{
    public function __construct(protected SliderService $sliderService)
    {
    }

    public function __invoke()
    {
        $sliders = $this->sliderService->getQuery(['status'=>ActivationStatus::ACTIVE->value])->orderBy('order')->get();
        return SlidersResource::collection($sliders);
    }


}
