<?php

namespace App\Http\Controllers\Therapist\Lecture;

use App\DataTables\Lecture\LecturesDatatable;
use App\DataTransferObjects\Lecture\UpdateLectureDTO;
use App\Exceptions\GeneralException;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\Lecture\LectureUpdateRequest;
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
    public function index(LecturesDatatable $lecturesDatatable, Request $request)
    {
        try {
            $filters = array_filter($request->get('filters', []), function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });

            if (isset($request->upcoming))
                $filters['upcoming'] = 1;
            return $lecturesDatatable->with(['filters' => $filters])->render('layouts.dashboard.lecture.index');
        } catch (\Exception $exception) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $exception->getMessage()];
            return back()->with('toast', $toast);
        }
    }

    public function create()
    {

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        try {
            $lecture = $this->lectureService->findById($id, withRelations: ['therapist']);
            return view('layouts.dashboard.lecture.edit', ['lecture' => $lecture]);
        } catch (\Exception|NotFoundException $exception) {
            $toast = ['type' => 'error', 'title' => 'Error', 'message' => $exception->getMessage()];
            return redirect(route('therapists.index'))->with('toast', $toast);
        }
    }

    /**
     * @param LectureUpdateRequest $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(LectureUpdateRequest $request, $id)
    {
        try {
            $lectureDTO = UpdateLectureDTO::fromRequest($request);
            $this->lectureService->update($lectureDTO, $id);
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'updated successfully'];
            return redirect(route('therapist-lectures.index'))->with('toast', $toast);
        }catch (\Exception $exception) {
            DB::rollBack();
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $exception->getMessage()];
            return redirect(route('therapist-lectures.index'))->with('toast', $toast);        }
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
