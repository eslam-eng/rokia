<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Rozmana\RozmanaDTO;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rozmana\RozmanaRequest;
use App\Http\Requests\Rozmana\RozmanaRequest as RozmanaUpdateRequest;
use App\Http\Resources\RozmanaResource;
use App\Services\RozmanaService;
use Illuminate\Http\Request;

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
        $filters['therapist_id'] = auth()->id();
        $allRozmana = $this->rozmanaService->paginate(filters: $filters);
        return RozmanaResource::collection($allRozmana);
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
            return apiResponse(message: __('app.rozmana.rozmana_created_successfully'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(),code: 500);
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
            $this->rozmanaService->update(dto: $rozamnaDTO,rozmana: $rozmana);
            return apiResponse(message: __('app.rozmana.rozmana_updated_successfully'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception,code: 500);
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
            return apiResponse(message:  __('app.rozmana.rozmana_deleted_successfully'));
        }catch (NotFoundException|\Exception $exception){
            return apiResponse(message:$exception->getMessage());
        }

    }
}
