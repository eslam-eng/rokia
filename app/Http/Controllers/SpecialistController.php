<?php

namespace App\Http\Controllers;

use App\DataTables\Specialist\SpecialistDataTable;
use App\DataTransferObjects\specialist\SpecialistDTO;
use App\Http\Requests\Specialist\SpecialistRequest;
use App\Models\Specialist;
use App\Services\Specialist\SpecialistService;
use Illuminate\Http\Request;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SpecialistController extends Controller
{
    public function __construct(public SpecialistService $specialistService)
    {
        //todo make polices as best practice
        $this->middleware('auth');
        $this->middleware(['permission:list_category'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:create_category'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:edit_category'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:delete_category'], ['only' => ['destroy']]);
        $this->middleware(['permission:change_category_status'], ['only' => ['status']]);
    }


    public function index(SpecialistDataTable $specialistDataTable, Request $request)
    {
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });

        return $specialistDataTable->with(['filters' => $filters])->render('layouts.dashboard.specialist.index');

    }

    public function create()
    {
        return view('layouts.dashboard.specialist.create');

    }

    public function store(SpecialistRequest $request)
    {
        try {
            $specialistDTO = SpecialistDTO::fromRequest($request);
            $this->specialistService->store($specialistDTO);
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'category created successfully'];
            return redirect(route('specialists.index'))->with('toast', $toast);
        } catch (\Exception $exception) {
            $toast = ['type' => 'error', 'title' => 'Success', 'message' => $exception->getMessage()];
            return back()->with('toast', $toast);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Specialist $specialist)
    {
        return view('layouts.dashboard.specialist.edit', compact('specialist'));
    }

    public function update(SpecialistRequest $request, Specialist $specialist)
    {
        try {
            $specialistDTO = SpecialistDTO::fromRequest($request);
            $this->specialistService->update($specialistDTO, $specialist);
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'category created successfully'];
            return redirect(route('specialists.index'))->with('toast', $toast);
        } catch (\Exception $exception) {
            $toast = ['type' => 'error', 'title' => 'Success', 'message' => $exception->getMessage()];
            return back()->with('toast', $toast);
        }
    }


    public function destroy(Specialist $specialist)
    {
        try {
            $this->specialistService->destroy($specialist);
            return apiResponse(message: 'deleted successfully');
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    public function status($id)
    {
        try {
            $this->specialistService->changeStatus(id: $id);
            return apiResponse(message: __('app.categories.status_changed_successfully'));
        } catch (NotFoundHttpException $exception) {
            return apiResponse(message: __('app.categories.category_not_found'), code: 404);
        } catch (Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }
}
