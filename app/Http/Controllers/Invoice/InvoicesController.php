<?php

namespace App\Http\Controllers\Invoice;

use App\DataTables\Invoice\InvoicesDataTable;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Services\Invoice\InvoiceService;
use Illuminate\Http\Request;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InvoicesController extends Controller
{

    public function __construct(public InvoiceService $invoiceService)
    {
        $this->middleware('auth');
        $this->middleware(['permission:list_invoices'], ['only' => ['index','show']]);
        $this->middleware(['permission:add_therapist_Invoice'], ['only' => ['therapistInvoice']]);
        $this->middleware(['permission:change_invoices_status'], ['only' => ['status']]);
    }

    public function index(InvoicesDataTable $invoicesDataTable, Request $request)
    {
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $invoicesDataTable->with(['filters' => $filters])->render('layouts.dashboard.invoice.index');
    }

    /**
     * @throws NotFoundException
     */
    public function show(Invoice $invoice)
    {
        $invoice = $this->invoiceService->findForView(invoice: $invoice);
        return view('layouts.dashboard.invoice.show', ['invoice' => $invoice]);
    }

    public function completeInvoice($id)
    {
        try {
            $this->invoiceService->completeInvoice(id: $id);
            return apiResponse(message: __('app.therapists.therapist_status_changed_successfully'));
        } catch (NotFoundHttpException $exception) {
            return apiResponse(message: __('app.therapist_not_found'), code: 404);
        } catch (Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

}
