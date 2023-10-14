<?php

namespace App\Http\Controllers\Api\Lecture;

use App\DataTransferObjects\Lecture\LectureDTO;
use App\DataTransferObjects\Lecture\UpdateLectureDTO;
use App\Enums\ActivationStatus;
use App\Enums\UsersType;
use App\Exceptions\GeneralException;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\Lecture\LectureRequest;
use App\Http\Requests\Lecture\LectureUpdateRequest;
use App\Http\Requests\Lecture\LiveLectureRequest;
use App\Http\Resources\LecturesResource;
use App\Models\User;
use App\Services\LectureService;
use App\Services\PushNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UserLectureController extends Controller
{
    public function __invoke()
    {
        try {
            $user = auth()->user();
            $user_lecture = $user->lecture()->get();
            return LecturesResource::collection($user_lecture);
        }catch (\Exception $exception)
        {
            return apiResponse(message: 'there is an error please try again later',code: 500);
        }

    }
}
