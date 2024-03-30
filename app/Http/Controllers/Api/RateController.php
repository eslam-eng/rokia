<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Rate\RateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\RateStoreRequest;
use App\Models\Rate;
use App\Services\RateService;

class RateController extends Controller
{
    public function __construct(public RateService $RateService)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(RateStoreRequest $request)
    {
        try {
            $rateDTO = RateDTO::fromRequest($request);
            $this->RateService->store($rateDTO);
            return apiResponse(message: __('app.general.thank_u_for_your_feedback'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(RateStoreRequest $request, Rate $rate)
    {
        try {

            $rateDTO = RateDTO::fromRequest($request);
            $this->RateService->update($rateDTO, $rate);
            return apiResponse(message: __('app.general.thank_u_for_your_feedback'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }


    public function destroy(Rate $rate)
    {
        try {
            if ($rate->user_id != auth()->id())
                return apiResponse(message: __('app.rates.cannot_delete_rate_not_belongs_to_u'),code: 422);
            $this->RateService->destroy($rate);
            return apiResponse(message: __('app.general.success_operation'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

}
