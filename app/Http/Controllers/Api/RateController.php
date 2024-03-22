<?php

namespace App\Http\Controllers\Api;

use App\Models\Rate;
use Illuminate\Http\Request;
use App\Services\RateService;
use App\Http\Controllers\Controller;
use App\Http\Requests\RateStoreRequest;
use App\DataTransferObjects\Rate\RateDTO;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RateStoreRequest $request)
    {
        try {
           
            $rateDTO = RateDTO::createFromRequest($request);
            $rate =$this->RateService->store($rateDTO);
            return response()->json(['message' => 'Rate created successfully', 'rate' => $rate], 201);
        } catch (\Exception $e) {
          
            return response()->json(['message' => 'Failed to create rate', 'error' => $e->getMessage()], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RateStoreRequest $request, Rate $rate)
    {
        // dd($request);
        try {
             
            $rateDTO = RateDTO::createFromRequest($request);
            $rate= $this->RateService->update($rateDTO,$rate);
          
            return response()->json(['message' => 'Rate updated successfully', 'rate' => $rate], 201);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Failed to update rate', 'error' => $e->getMessage()], 500);
        }
    }


    public function destroy(Rate $rate)
    {
        try {
            $this->RateService->destroy($rate);
            return apiResponse(message: 'deleted successfully');
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

}
