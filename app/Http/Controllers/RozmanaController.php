<?php

namespace App\Http\Controllers;

use App\DataTables\Rozmana\RozmanaDataTable;
use Illuminate\Http\Request;

class RozmanaController extends Controller
{
    public function __invoke(RozmanaDataTable $rozmanaDataTable,Request $request)
    {
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });

        return $rozmanaDataTable->with(['filters'=>$filters])->render('layouts.dashboard.rozmana.index');

    }
}
