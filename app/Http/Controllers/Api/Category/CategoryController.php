<?php

namespace App\Http\Controllers\Api\Category;

use App\Enums\ActivationStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Services\Category\CategoryService;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService)
    {
    }

    public function __invoke()
    {
        $filters = ['status'=>ActivationStatus::ACTIVE->value];
        $categories = $this->categoryService->getAll(filters: $filters);
        return CategoryResource::collection($categories);
    }


}
