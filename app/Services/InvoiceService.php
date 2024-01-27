<?php

namespace App\Services;

use App\Enums\InvoiceStatus;
use App\Exceptions\GeneralException;
use App\Exceptions\NotFoundException;
use App\Filters\InvoicesFilter;
use App\Models\Invoice;
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

    public function paginateInvoices(array $filters = []): \Illuminate\Contracts\Pagination\Paginator
    {
        return $this->getQuery(filters: $filters)
            ->withCount('items')
            ->simplePaginate();
    }

    public function datatable(array $filters = []): Builder
    {

        return $this->getQuery(filters: $filters)
            ->withCount('items')
            ->with('therapist');
    }

    /**
     * @throws NotFoundException
     */
    public function findForView(int|Invoice $invoice)
    {
        if (is_int($invoice))
            return $this->findById(id: $invoice, withRelations: ['items', 'therapist']);
        return $invoice->load(['items', 'therapist']);
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
        if ($invoice->status == InvoiceStatus::COMPLETED->value)
            throw new GeneralException('invoice already completed');
        return $invoice->update(['status' => InvoiceStatus::COMPLETED->value]);
    }
}
