<?php

namespace App\Http\Controllers\Slider;

use App\DataTables\Slider\SlidersDataTable;
use App\DataTransferObjects\Slider\SliderDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Slider\SliderRequest;
use App\Models\Slider;
use App\Services\SliderService;
use Illuminate\Http\Request;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SliderController extends Controller
{
    public function __construct(public SliderService $sliderService)
    {
    }


    public function index(SlidersDataTable $slidersDataTable, Request $request)
    {
        try {
            $filters = array_filter($request->get('filters', []), function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });

            return $slidersDataTable->with(['filters' => $filters])->render('layouts.dashboard.slider.index');
        } catch (\Exception $exception) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $exception->getMessage()];
            return back()->with('toast', $toast);
        }
    }

    public function create()
    {
        return view('layouts.dashboard.slider.create');

    }

    public function store(SliderRequest $request)
    {
        try {
            $sliderDTO = SliderDTO::fromRequest($request);
            $this->sliderService->store($sliderDTO);
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'slider created successfully'];
            return redirect(route('sliders.index'))->with('toast', $toast);
        } catch (\Exception $exception) {
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => $exception->getMessage()];
            return back()->with('toast', $toast);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Slider $slider)
    {
        return view('layouts.dashboard.slider.edit', compact('slider'));
    }

    public function update(SliderRequest $request, Slider $slider)
    {
        try {
            $sliderDTO = SliderDTO::fromRequest($request);
            $this->sliderService->update($sliderDTO,$slider);
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'slider created successfully'];
            return redirect(route('sliders.index'))->with('toast', $toast);
        } catch (\Exception $exception) {
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => $exception->getMessage()];
            return back()->with('toast', $toast);
        }
    }


    public function destroy(Slider $slider)
    {
        try {
            $this->sliderService->destroy($slider);
            return apiResponse(message: 'deleted successfully');
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    public function status($id)
    {
        try {
            $this->sliderService->changeStatus(id: $id);
            return apiResponse(message: __('app.therapist_status_changed_successfully'));
        } catch (NotFoundHttpException $exception) {
            return apiResponse(message: __('app.therapist_not_found'), code: 404);
        } catch (Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }
}
