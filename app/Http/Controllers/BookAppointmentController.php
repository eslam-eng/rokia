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
        $this->middleware(['permission:list_appointment'], ['only' => ['index']]);

    }


    public function index(BookAppointmentDataTable $appointmentDataTable, Request $request)
    {
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });

        return $appointmentDataTable->with(['filters' => $filters])->render('layouts.dashboard.book-appointments.index');

    }

}
