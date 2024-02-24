<?php

namespace App\Http\Controllers\Therapist\Plans;

use App\DataTables\Therapist\TherapistsDataTable;
use App\DataTables\TherapistPlans\TherapistPlansDataTable;
use App\Http\Controllers\Controller;
use App\Services\Plans\TherapistPlansService;
use Illuminate\Http\Request;

class TherapistPlansController extends Controller
{
    public function __construct(protected TherapistPlansService $therapistPlansService)
    {
    }

    public function __invoke(TherapistPlansDataTable $dataTable, Request $request)
    {
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters' => $filters])->render('layouts.dashboard.therapist-plans.index');
    }

}
