<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;

class LectureReportController extends Controller
{
    public function __invoke()
    {
        return view('layouts.dashboard.reports.lecture-report');
    }
}
