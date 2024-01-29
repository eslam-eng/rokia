<?php

namespace App\Services;

use App\DataTransferObjects\Rozmana\RozmanaDTO;
use App\Exceptions\NotFoundException;
use App\Filters\RozmanaFilter;
use App\Models\Rozmana;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RozmanaService extends BaseService
{

    public function __construct(protected Rozmana $model)
    {

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getQuery(?array $filters = []): ?Builder
    {
        return parent::getQuery($filters)
            ->when(!empty($filters), fn(Builder $builder) => $builder->filter(new RozmanaFilter($filters)));
    }

    public function paginate(array $filters = []): \Illuminate\Contracts\Pagination\Paginator
    {
        return $this->getQuery(filters: $filters)
            ->paginate();
    }

    public function datatable(array $filters = []): Builder
    {
        return $this->getQuery(filters: $filters)
            ->with('therapist');
    }

    public function create(RozmanaDTO $dto)
    {
        $dto->validate();
        return $this->getQuery()->create($dto->toArray());
    }

    /**
     * @throws NotFoundException
     */
    public function update(RozmanaDTO $dto, Rozmana|int $rozmana)
    {
        $dto->validate();
        if (is_int($rozmana))
            $rozmana = $this->findById($rozmana);
        if (!$rozmana)
            throw new NotFoundException(message: __('app.rozmana.rozmana_not_fount'));
        return $rozmana->update($dto->toArray());
    }

    public function destroy(Rozmana|int $rozmana)
    {
        if (is_int($rozmana))
            $rozmana = $this->findById($rozmana);
        if (!$rozmana)
            throw new NotFoundException(message:  __('app.rozmana.rozmana_not_fount'));
        return $rozmana->delete();
    }
}
