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

class LectureController extends Controller
{
    public function __construct(public LectureService $lectureService,public PushNotificationService $pushNotificationService)
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            $withRelations = [];
            $filters =[];

            if ($user->type == UsersType::CLIENT->value) {
                $filters = $request->all();
                $filters['status'] = ActivationStatus::ACTIVE->value;
                $withRelations = ['therapist:id,name'];
            }
            if ($user->type == UsersType::THERAPIST->value) {
                $filters['therapist_id'] = $user->id;
            }
            $lectures = $this->lectureService->paginateLectures($filters, $withRelations);
            return LecturesResource::collection($lectures);
        } catch (\Exception $exception) {
            return apiResponse(message: 'something went wrong', code: 500);
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(LectureRequest $request)
    {
       return  $this->storeLecture($request);
    }

    public function storeLiveLecture(LiveLectureRequest $request)
    {
        return $this->storeLecture($request);
    }

    private function storeLecture(LiveLectureRequest|LectureRequest $request)
    {
        try {
            $user = auth()->user();
            DB::beginTransaction();
            $lectureDTO = LectureDTO::fromRequest($request);
            $lecture = $this->lectureService->store($lectureDTO);
            DB::commit();
            $usersTokens = User::query()->pluck('device_token')->toArray();
            $usersTokens = array_filter($usersTokens);
            if (count($usersTokens)){
                $title = "$user->name تم رفع محاضرة للشيخ ";
                $content = "$lecture->publish_date تاريخ بدء المحاضره يوم  $lecture->title عنوان المحاضره ";
                $this->pushNotificationService->sendToTokens($title,$content,$usersTokens);
            }
            return apiResponse(message: 'Lecture uploaded successfully');
        } catch (ValidationException $exception) {
            DB::rollBack();
            $mappedErrors = collect($exception->errors())->map(function ($error, $key) {
                return [
                    "key" => $key,
                    "error" => Arr::first($error),
                ];
            })->values()->toArray();
            return response(['message' => __('lang.invalid inputs'), 'errors' => $mappedErrors], 422);
        } catch (\Exception $exception) {
            DB::rollBack();
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(LectureUpdateRequest $request, $id)
    {
        try {
            $lectureDTO = UpdateLectureDTO::fromRequest($request);
            $this->lectureService->update($lectureDTO, $id);
            return apiResponse(message: 'Lecture uploaded successfully');
        } catch (ValidationException $exception) {
            DB::rollBack();
            $mappedErrors = collect($exception->errors())->map(function ($error, $key) {
                return [
                    "key" => $key,
                    "error" => Arr::first($error),
                ];
            })->values()->toArray();
            return response(['message' => __('lang.invalid inputs'), 'errors' => $mappedErrors], 422);
        } catch (\Exception $exception) {
            DB::rollBack();
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->lectureService->destroy($id);
            return apiResponse(message: 'deleted successfully');
        } catch (GeneralException $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    public function updateImageCover(ImageUploadRequest $request, $id)
    {
        try {
            $lecture = $this->lectureService->findById($id);
            $media = $lecture->getMedia('*', ['type', 'image'])->first();
            $media?->delete();
            $lecture->addMediaFromRequest('file')->withCustomProperties(['type' => 'image'])
                ->toMediaCollection();
            return apiResponse(message: 'updated successfully');
        } catch (NotFoundException $exception) {
            return apiResponse(message: $exception->getMessage(), code: 404);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }
}
