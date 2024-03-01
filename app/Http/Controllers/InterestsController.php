<?php

namespace App\Http\Controllers;

use App\DataTables\Category\InterestsDatatable;
use App\DataTransferObjects\Interests\InterestDTO;
use App\Http\Requests\Category\InteresetRequest;
use App\Models\Interest;
use App\Services\Interest\InterestService;
use Illuminate\Http\Request;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InterestsController extends Controller
{
    public function __construct(public InterestService $interestService)
    {
        //todo make polices as best practice
        $this->middleware('auth');
        $this->middleware(['permission:list_category'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:create_category'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:edit_category'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:delete_category'], ['only' => ['destroy']]);
        $this->middleware(['permission:change_category_status'], ['only' => ['status']]);
    }


    public function index(InterestsDatatable $interestsDatatable, Request $request)
    {
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });

        return $interestsDatatable->with(['filters' => $filters])->render('layouts.dashboard.interest.index');

    }

    public function create()
    {
        return view('layouts.dashboard.interest.create');

    }

    public function store(InteresetRequest $request)
    {
        try {
            $interestDTO = InterestDTO::fromRequest($request);
            $this->interestService->store($interestDTO);
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'category created successfully'];
            return redirect(route('interests.index'))->with('toast', $toast);
        } catch (\Exception $exception) {
            $toast = ['type' => 'error', 'title' => 'Success', 'message' => $exception->getMessage()];
            return back()->with('toast', $toast);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Interest $interest)
    {
        return view('layouts.dashboard.interest.edit', compact('interest'));
    }

    public function update(InteresetRequest $request, Interest $interest)
    {
        try {
            $interestDTO = InterestDTO::fromRequest($request);
            $this->interestService->update($interestDTO, $interest);
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'category created successfully'];
            return redirect(route('interests.index'))->with('toast', $toast);
        } catch (\Exception $exception) {
            $toast = ['type' => 'error', 'title' => 'Success', 'message' => $exception->getMessage()];
            return back()->with('toast', $toast);
        }
    }


    public function destroy(Interest $interest)
    {
        try {
            $this->interestService->destroy($interest);
            return apiResponse(message: 'deleted successfully');
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    public function status($id)
    {
        try {
            $this->interestService->changeStatus(id: $id);
            return apiResponse(message: __('app.interests.status_changed_successfully'));
        } catch (NotFoundHttpException $exception) {
            return apiResponse(message: __('app.interests.interest_not_found'), code: 404);
        } catch (Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }
}
