<?php

namespace App\Http\Controllers\Therapist;

use Mockery\Exception;
use App\Enums\UsersType;
use App\Models\Therapist;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Exceptions\NotFoundException;
use App\DataTransferObjects\Rate\RateDTO;
use App\Services\Therapist\TherapistService;
use Illuminate\Validation\ValidationException;
use App\DataTables\Therapist\TherapistsDataTable;
use App\Http\Requests\Therapist\ThereapistUpdateRequest;
use App\DataTransferObjects\Therapist\UpdateTherapistDTO;
use App\DataTables\TherapistSchedule\TherapistScheduleDataTable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TherapistController extends Controller
{
    public function __construct(protected TherapistService $therapistService, public UserService $service)
    {
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

    public function storeRateLecture(Request $request, int $therapistId)
    {
        try {
            $therapist= $this->therapistService->findById($therapistId);
            
            if (!$therapist) {
                return apiResponse(message: 'therapist not found', code: 404);
            }

            $rateDTO = RateDTO::fromRequest($request);
            $this->therapistService->storeRateForTherapist($therapist, $rateDTO);
            
            return apiResponse(message: 'Rate stored successfully');
        } catch (NotFoundException $exception) {
            return apiResponse(message: $exception->getMessage(), code: 404);
        } catch (ValidationException $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

}
