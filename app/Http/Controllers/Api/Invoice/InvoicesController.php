<?php

namespace App\Http\Controllers\Api\Invoice;

use App\DataTables\Invoice\InvoicesDataTable;
use App\Http\Controllers\Controller;
use App\Services\InvoiceService;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{

    public function __construct(public InvoiceService $invoiceService)
    {
    }

    public function index(InvoicesDataTable $invoicesDataTable , Request $request)
    {
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $invoicesDataTable->with(['filters' => $filters])->render('layouts.dashboard.invoice.index');
    }
}
