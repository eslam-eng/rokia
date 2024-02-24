<?php

namespace App\Http\Controllers\Api\Category;

use App\Enums\ActivationStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category\InterestsResource;
use App\Services\Interest\InterestService;

class InterestsController extends Controller
{
    public function __construct(protected InterestService $interestService)
    {
    }

    public function __invoke()
    {
        $filters = ['status'=>ActivationStatus::ACTIVE->value];
        $categories = $this->interestService->getAll(filters: $filters);
        return InterestsResource::collection($categories);
    }


}
