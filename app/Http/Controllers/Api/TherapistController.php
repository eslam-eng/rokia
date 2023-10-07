<?php

namespace App\Http\Controllers\Api;

use App\DataTables\TherapistsDataTable;
use App\DataTransferObjects\Therapist\TherapistDTO;
use App\Enums\UsersType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ThereapistRequest;
use App\Services\TherapistService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
    }

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
}
