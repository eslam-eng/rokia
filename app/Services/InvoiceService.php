<?php

namespace App\Services;

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
}
