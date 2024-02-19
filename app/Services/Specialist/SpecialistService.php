<?php

namespace App\Services\Specialist;

use App\DataTransferObjects\category\CategoryDTO;
use App\DataTransferObjects\specialist\SpecialistDTO;
use App\Filters\CategoriesFilter;
use App\Filters\SpecialistsFilter;
use App\Models\Category;
use App\Models\Specialist;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SpecialistService extends BaseService
{

    public function __construct(protected Specialist $model)
    {

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getQuery(?array $filters = []): ?Builder
    {
        return parent::getQuery($filters)
            ->when(!empty($filters), fn(Builder $builder) => $builder->filter(new SpecialistsFilter($filters)));
    }


    public function datatable(array $filters = []): Builder
    {
        return $this->getQuery(filters: $filters);
    }

    public function store(SpecialistDTO $specialistDTO)
    {
        $specialistDTO->validate();
        $specialistData = $specialistDTO->toArray();
        return $this->getQuery()->create($specialistData);
    }


    public function update(SpecialistDTO $specialistDTO, int|Specialist $specialist)
    {
        if (is_int($specialist))
            $specialist = $this->findById($specialist);
        return $specialist->update($specialistDTO->toArray());
    }


    public function destroy(int|Specialist $specialist): ?bool
    {
        if (is_int($specialist))
            $specialist = $this->findById($specialist);
        return $specialist->delete();
    }


    public function changeStatus($id): bool
    {
        $specialist = $this->findById($id);
        $specialist->status = !$specialist->status;
        return $specialist->save();
    }

    public function getAll(array $filters = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->getQuery($filters)->get();
    }
}
