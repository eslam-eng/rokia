<?php

namespace App\Http\Controllers\Therapist;

use App\DataTables\TherapistsDataTable;
use App\DataTransferObjects\Therapist\TherapistDTO;
use App\Enums\UsersType;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Therapist\ThereapistUpdateRequest;
use App\Http\Requests\Users\ThereapistRequest;
use App\Services\TherapistService;
use App\Services\UserService;
use App\Traits\HasMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Mockery\Exception;
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

    public function store(ThereapistRequest $request)
    {
        try {
            DB::beginTransaction();
            $therapistDTO = TherapistDTO::fromRequest($request);
            $this->therapistService->store($therapistDTO);
            DB::commit();
            return apiResponse(message: 'therapist registered successfully');
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
            return apiResponse(message: 'Something Went Wrong', code: 500);
        }
    }

    public function edit(int $id)
    {
        try {
            $therapist = $this->therapistService->findById($id);
            return view('layouts.dashboard.therapist.edit', compact('therapist'));
        } catch (NotFoundHttpException|\Exception $exception) {
            $toast = [
                'type' => 'error',
                'title' => 'error',
                'message' => $exception->getMessage()
            ];
            return back()->with('toast', $toast);
        }

    }

    public function update(ThereapistUpdateRequest $request, $therapist)
    {
        try {
            DB::beginTransaction();
            $therapistDTO = TherapistDTO::fromRequest($request);
            $this->therapistService->update($therapistDTO, $therapist);
            DB::commit();
            $toast = [
                'type' => 'success',
                'title' => 'Success',
                'message' => 'updated successfully'
            ];
            return redirect(route('therapists.index'))->with('toast', $toast);
        } catch (\Exception $exception) {
            DB::rollBack();
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
}
