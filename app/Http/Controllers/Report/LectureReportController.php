<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;

class LectureReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['permission:lecture_report']);
    }
    public function __invoke()
    {
        return view('layouts.dashboard.reports.lecture-report');
    }
}
