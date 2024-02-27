<?php

namespace App\Http\Controllers\Api\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Resources\Invoice\InvoicesResource;
use App\Models\Invoice;
use App\Services\Invoice\InvoiceService;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{

    public function __construct(public InvoiceService $invoiceService)
    {
    }

    public function index(Request $request)
    {
        $filters = array_filter($request->all(), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $filters['therapist_id'] = auth()->guard('api_therapist')->id();
        $invoices = $this->invoiceService->paginateInvoices(filters: $filters);
        return InvoicesResource::collection($invoices);
    }

    public function show(Invoice $invoice)
    {
        $invoice = $this->invoiceService->findForView(invoice: $invoice);
        return InvoicesResource::make($invoice);
    }
}
