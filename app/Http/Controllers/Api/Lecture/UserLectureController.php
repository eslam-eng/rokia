<?php

namespace App\Http\Controllers\Api\Lecture;

use App\Http\Controllers\Controller;
use App\Http\Resources\LecturesResource;
use App\Services\LectureService;

class UserLectureController extends Controller
{
    public function __construct(public LectureService $lectureService)
    {
    }

    public function __invoke()
    {
        try {
            $user = auth()->user();
            $user_lecture =$this->lectureService->getLecturesForUser($user);
            return LecturesResource::collection($user_lecture);
        } catch (\Exception $exception) {
            return apiResponse(message: 'there is an error please try again later', code: 500);
        }

    }
}
