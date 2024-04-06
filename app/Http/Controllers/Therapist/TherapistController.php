<?php

namespace App\Http\Controllers\Therapist;

use App\DataTables\Therapist\TherapistsDataTable;
use App\DataTables\TherapistSchedule\TherapistScheduleDataTable;
use App\DataTransferObjects\Therapist\UpdateTherapistDTO;
use App\Enums\UsersType;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Therapist\ThereapistUpdateRequest;
use App\Models\Therapist;
use App\Services\Therapist\TherapistService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TherapistController extends Controller
{
    public function __construct(protected TherapistService $therapistService, public UserService $service)
    {
        $this->middleware('auth');
        $this->middleware(['permission:list_therapists'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:edit_therapist'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:change_therapist_status'], ['only' => ['status']]);
    }

    public function index(TherapistsDataTable $dataTable, Request $request)
    {
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $filters['type'] = UsersType::THERAPIST->value;
        return $dataTable->with(['filters' => $filters])->render('layouts.dashboard.therapist.index');
    }

//    public function create()
//    {
//        return view('layouts.dashboard.therapist.create');
//    }

//    public function store(ThereapistRequest $request)
//    {
//        try {
//            DB::beginTransaction();
//            $therapistDTO = CreateTherapistDTO::fromRequest($request);
//            $this->therapistService->store($therapistDTO);
//            DB::commit();
//            return apiResponse(message: 'therapist registered successfully');
//        } catch (ValidationException $exception) {
//            DB::rollBack();
//            $mappedErrors = transformValidationErrors($exception->errors());
//            return response(['message' => __('lang.invalid inputs'), 'errors' => $mappedErrors], 422);
//        } catch (\Exception $exception) {
//            DB::rollBack();
//            return apiResponse(message: 'Something Went Wrong', code: 500);
//        }
//    }

    public function edit(Therapist $therapist)
    {
        return view('layouts.dashboard.therapist.edit', compact('therapist'));
    }

    public function update(ThereapistUpdateRequest $request, Therapist $therapist)
    {
        try {

            $therapistDTO = UpdateTherapistDTO::fromRequest($request);
            $this->therapistService->update($therapistDTO, $therapist);
            $toast = [
                'type' => 'success',
                'title' => 'Success',
                'message' => 'updated successfully'
            ];
            return redirect(route('therapists.index'))->with('toast', $toast);
        } catch (ValidationException $exception) {
            // Validation failed; handle the exception
            return back()->withErrors($exception->validator->errors())
                ->withInput();
        } catch (\Exception $exception) {
            $toast = [
                'type' => 'error',
                'title' => 'error',
                'message' => $exception->getMessage()
            ];
            return back()->with('toast', $toast);
        }
    }

    /**
     * @throws GeneralException
     */
    public function status(Request $request, $id)
    {
        try {
            $this->therapistService->changeStatus(id: $id, status: $request->get('status'));
            return apiResponse(message: __('app.therapist_status_changed_successfully'));
        } catch (NotFoundHttpException $exception) {
            return apiResponse(message: __('app.therapist_not_found'), code: 404);
        } catch (Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $filters = [
            'keyword' => $keyword,
        ];

        return $this->therapistService->search(filters: $filters);
    }

    public function showSchedules(TherapistScheduleDataTable $therapistScheduleDataTable, Request $request)
    {
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $filters['therapist_id'] = $request->therapist;
        return $therapistScheduleDataTable->with(['filters' => $filters])->render('layouts.dashboard.therapist-schedules.index');
    }
}
