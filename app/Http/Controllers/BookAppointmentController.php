<?php

namespace App\Http\Controllers;

use App\DataTables\BookAppointment\BookAppointmentDataTable;
use App\DataTables\Category\InterestsDatatable;
use App\DataTransferObjects\Interests\InterestDTO;
use App\Http\Requests\Category\InteresetRequest;
use App\Models\Category;
use App\Services\Interest\InterestService;
use Illuminate\Http\Request;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookAppointmentController extends Controller
{
    public function __construct(public InterestService $categoryService)
    {
        //todo make polices as best practice
        $this->middleware('auth');
        $this->middleware(['permission:list_interest'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:create_interest'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:edit_interest'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:delete_interest'], ['only' => ['destroy']]);
        $this->middleware(['permission:change_interest_status'], ['only' => ['status']]);
    }


    public function index(BookAppointmentDataTable $appointmentDataTable, Request $request)
    {
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });

        return $appointmentDataTable->with(['filters' => $filters])->render('layouts.dashboard.book-appointments.index');

    }

}
