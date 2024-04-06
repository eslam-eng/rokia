<?php

namespace App\Http\Controllers;

use App\DataTables\Rozmana\RozmanaDataTable;
use App\Services\RozmanaService;
use App\Services\Therapist\TherapistService;
use Illuminate\Http\Request;

class RozmanaController extends Controller
{
    public function __construct(public RozmanaService $rozmanaService, public TherapistService $therapistService)
    {
        //todo make polices as best practice
        $this->middleware('auth');
        $this->middleware(['permission:list_rozmana'], ['only' => ['index', 'show']]);
    }

    public function index(Request $request)
    {
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });

        $therapists = $this->therapistService->datatable(filters: $filters)->withCount('rozmans')->paginate();
        return view('layouts.dashboard.rozmana.index', ['therapists' => $therapists]);
    }

    public function show(RozmanaDataTable $rozmanaDataTable, Request $request, int $therapist_id)
    {

        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });

        $filters['therapist_id'] = $therapist_id;
        return $rozmanaDataTable->with(['filters' => $filters])->render('layouts.dashboard.rozmana.show');

    }
}
