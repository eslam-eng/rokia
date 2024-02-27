<?php

namespace App\Services\Invoice;

use App\DataTransferObjects\TherapistPlans\TherapistPlansDTO;
use App\Enums\InvoiceStatusEnum;
use App\Exceptions\GeneralException;
use App\Exceptions\NotFoundException;
use App\Filters\InvoiceItemsFilter;
use App\Filters\InvoicesFilter;
use App\Filters\TherapistPlansFilter;
use App\Models\Invoice;
use App\Models\TherapistPlan;
use App\Services\BaseService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class InvoiceItemService extends BaseService
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
            ->when(!empty($filters), fn(Builder $builder) => $builder->filter(new InvoiceItemsFilter($filters)));
    }

    public function paginateInvoiceItems(array $filters = []): Paginator
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


}
