<?php

namespace App\Http\Controllers\Api\Lecture;

use App\DataTransferObjects\Lecture\LectureDTO;
use App\DataTransferObjects\Lecture\UpdateLectureDTO;
use App\Enums\ActivationStatus;
use App\Exceptions\GeneralException;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\Lecture\LectureRequest;
use App\Http\Requests\Lecture\LectureUpdateRequest;
use App\Http\Requests\Lecture\LiveLectureRequest;
use App\Http\Resources\Lecture\LecturesResource;
use App\Http\Resources\Lecture\TherapistLecturesResource;
use App\Services\LectureService;
use App\Traits\NotifyUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LectureController extends Controller
{
    use NotifyUsers;
    public function __construct(public LectureService $lectureService)
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $user_id = auth()->guard('api_therapist')->id();
            $filters = array_filter($request->all(), function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });

            $filters['therapist_id'] = $user_id;
            $lectures = $this->lectureService->getTherapistLectures(filters: $filters);
            return TherapistLecturesResource::collection($lectures);
        } catch (\Exception $exception) {
            return apiResponse(message: 'something went wrong', code: 500);
        }
    }

    public function getLecturesForUser(Request $request)
    {
        try {
            $filters = array_filter($request->all(), function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });
            $filters['status'] = ActivationStatus::ACTIVE->value;
            $lectures = $this->lectureService->getAllLectureForUser(filters: $filters);
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

            $title = "$user->name تم رفع محاضرة للشيخ ";
            $content = "$lecture->publish_date تاريخ بدء المحاضرة يوم  $lecture->title عنوان المحاضرة ";

            $this->notifyUsers(title: $title , content: $content);
            return apiResponse(message: __('app.lectures.lecture_upload_success'));

        } catch (ValidationException $exception) {
            DB::rollBack();
            $mappedErrors = transformValidationErrors($exception->errors());
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
            $mappedErrors = transformValidationErrors($exception->errors());
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
            $media = $lecture->getMedia('lectures_covers')->first();
            $media?->delete();
            $lecture->addMediaFromRequest('image')->toMediaCollection('lectures_covers');
            return apiResponse(message: __('app.general.success_operation'));
        } catch (NotFoundException $exception) {
            return apiResponse(message: $exception->getMessage(), code: 404);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    public function closeLecture(int $lecture)
    {
        try {
           $this->lectureService->closeLecture($lecture);
            return apiResponse(message: __('app.general.success_operation'));
        }catch (NotFoundException $exception) {
            return apiResponse(message: $exception->getMessage(), code: 404);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }
}
