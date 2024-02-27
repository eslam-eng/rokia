<?php

namespace App\Services\Invoice;

use App\Enums\InvoiceStatusEnum;
use App\Exceptions\GeneralException;
use App\Exceptions\NotFoundException;
use App\Filters\InvoicesFilter;
use App\Models\Invoice;
use App\Services\BaseService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class InvoiceService extends BaseService
{

    public function __construct(protected Invoice $model)
    {

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getQuery(?array $filters = []): ?Builder
    {
        return parent::getQuery($filters)
            ->when(!empty($filters), fn(Builder $builder) => $builder->filter(new InvoicesFilter($filters)));
    }

    public function paginateInvoices(array $filters = []): Paginator
    {
        return $this->getQuery(filters: $filters)
            ->withCount('invoiceItems')
            ->simplePaginate();
    }

    public function datatable(array $filters = []): Builder
    {

        return $this->getQuery(filters: $filters)
            ->withCount('invoiceItems')
            ->with('therapist:id,name');
    }

    /**
     * @throws NotFoundException
     */
    public function findForView(int|Invoice $invoice)
    {
        if (is_int($invoice))
            return $this->getQuery()->where('id',$invoice)
                ->withCount('invoiceItems')
                ->with(['invoiceItems.client:id,name', 'therapist:id,name']);

        return $invoice
            ->loadCount('invoiceItems')
            ->load(['invoiceItems.client:id,name', 'therapist:id,name']);
    }

    /**
     * @throws NotFoundException
     * @throws GeneralException
     */
    public function completeInvoice($id): bool
    {
        $invoice = $this->findById($id);
        if (!$invoice)
            throw new NotFoundException('invoice not found');
        if ($invoice->status == InvoiceStatusEnum::COMPLETED->value)
            throw new GeneralException('invoice already completed');
        return $invoice->update(['status' => InvoiceStatusEnum::COMPLETED->value]);
    }
}
