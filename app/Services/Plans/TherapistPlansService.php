<?php

namespace App\Services\Plans;

use App\DataTransferObjects\TherapistPlans\TherapistPlansDTO;
use App\Filters\TherapistPlansFilter;
use App\Models\TherapistPlan;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TherapistPlansService extends BaseService
{

    public function __construct(protected TherapistPlan $model)
    {

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getQuery(?array $filters = []): ?Builder
    {
        return parent::getQuery($filters)
            ->when(!empty($filters), fn(Builder $builder) => $builder->filter(new TherapistPlansFilter($filters)));
    }


    public function datatable(array $filters = []): Builder
    {
        return $this->getQuery(filters: $filters);
    }

    public function store(TherapistPlansDTO $therapistPlansDTO)
    {
        $therapistPlansDTO->validate();
        $therapistPlansData = $therapistPlansDTO->toArray();
        return $this->getQuery()->create($therapistPlansData);
    }


    public function update(TherapistPlansDTO $therapistPlansDTO, int|TherapistPlan $therapistPlan)
    {
        if (is_int($therapistPlan))
            $therapistPlan = $this->findById($therapistPlan);
        return $therapistPlan->update($therapistPlansDTO->toArray());
    }


    public function destroy(int|TherapistPlan $therapistPlan): ?bool
    {
        if (is_int($therapistPlan))
            $therapistPlan = $this->findById($therapistPlan);
        return $therapistPlan->delete();
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
