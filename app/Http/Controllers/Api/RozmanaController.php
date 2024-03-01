<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Rozmana\RozmanaDTO;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rozmana\RozmanaRequest;
use App\Http\Requests\Rozmana\RozmanaRequest as RozmanaUpdateRequest;
use App\Http\Requests\Rozmana\RozmanaUploadTemplateRequest;
use App\Http\Resources\RozmanaResource;
use App\Imports\RozmanaImport;
use App\Services\RozmanaService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class RozmanaController extends Controller
{

    public function __construct(public RozmanaService $rozmanaService)
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $auth_id = auth()->id();
        $filters['therapist_id'] = $auth_id;
        $allRozmana = $this->rozmanaService->paginate(filters: $filters);
        $rozmanCount = $this->rozmanaService->getQuery(['therapist_id'=>$auth_id])->count();
        return RozmanaResource::collection($allRozmana)->additional(['total_rozmana' => $rozmanCount]);;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RozmanaRequest $request)
    {
        try {
            $rozamnaDTO = RozmanaDTO::fromRequest($request);
            $this->rozmanaService->create(dto: $rozamnaDTO);
            return apiResponse(message: __('app.general.success_operation'));
        }catch (ValidationException $exception) {
            $mappedErrors = transformValidationErrors($exception->errors());
            return response(['message' => __('lang.invalid inputs'), 'errors' => $mappedErrors], 422);
        }
        catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(RozmanaUpdateRequest $request, $rozmana)
    {
        try {
            $rozamnaDTO = RozmanaDTO::fromRequest($request);
            $this->rozmanaService->update(dto: $rozamnaDTO, rozmana: $rozmana);
            return apiResponse(message: __('app.rozmana.rozmana_updated_successfully'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception, code: 500);
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
            $this->rozmanaService->destroy(rozmana: $id);
            return apiResponse(message: __('app.rozmana.rozmana_deleted_successfully'));
        } catch (NotFoundException|\Exception $exception) {
            return apiResponse(message: $exception->getMessage());
        }
    }

    public function uploadExceltemplate(RozmanaUploadTemplateRequest $request)
    {
        $errors = [];
        try {
            $file = $request->file('file');
            $therapist_id = auth()->id();
            (new RozmanaImport(therapist_id: $therapist_id))->import($file);
            return apiResponse(message: __('app.rozmana.imported_suceesfully'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $errors[] = [
                    "key" => $failure->attribute(),
                    "error" => "row " . $failure->row() . " | " . Arr::first($failure->errors()),
                ];
            }

            return apiResponse(data: $errors, message: __('app.rozmana.there_is_errors_in_file'), code: 422);
        }

    }
}
