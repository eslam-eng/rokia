<?php

namespace App\Http\Controllers\Therapist\Lecture;

use App\DataTables\Lecture\LecturesDatatable;
use App\DataTransferObjects\Lecture\LectureDTO;
use App\DataTransferObjects\Lecture\UpdateLectureDTO;
use App\Exceptions\GeneralException;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\Lecture\LectureRequest;
use App\Http\Requests\Lecture\LectureUpdateRequest;
use App\Http\Requests\Lecture\LiveLectureRequest;
use App\Services\LectureService;
use App\Traits\NotifyUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LectureController extends Controller
{
    use NotifyUsers;
    public function __construct(public LectureService $lectureService)
    {
    }

    /**
     * @param LecturesDatatable $lecturesDatatable
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function index(LecturesDatatable $lecturesDatatable , Request $request)
    {
        try {
            $filters = array_filter($request->get('filters', []), function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });

            if (isset($request->upcoming))
                $filters['upcoming'] = 1 ;
            return $lecturesDatatable->with(['filters' => $filters])->render('layouts.dashboard.lecture.index');
        } catch (\Exception $exception) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $exception->getMessage()];
            return back()->with('toast', $toast);
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

            $this->notifyUsers(title: $title,content: $content);

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

    public function status(Request $request, $id)
    {
        try {
            $this->lectureService->changeStatus(id: $id, status: $request->get('status'));
            return apiResponse(message: __('app.lecture_status_changed_successfully'));
        } catch (NotFoundHttpException $exception) {
            return apiResponse(message: __('app.lecture_not_found'), code: 404);
        } catch (Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }
}
