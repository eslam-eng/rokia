<?php

namespace App\Services\Interest;

use App\DataTransferObjects\Interests\InterestDTO;
use App\Filters\InterestsFilter;
use App\Models\Interest;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class InterestService extends BaseService
{

    public function __construct(protected Interest $model)
    {

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getQuery(?array $filters = []): ?Builder
    {
        return parent::getQuery($filters)
            ->when(!empty($filters), fn(Builder $builder) => $builder->filter(new InterestsFilter($filters)));
    }


    public function datatable(array $filters = []): Builder
    {
        return $this->getQuery(filters: $filters);
    }

    public function store(InterestDTO $interesDTO)
    {
        $interesDTO->validate();
        $interesData = $interesDTO->toArray();
        return $this->getQuery()->create($interesData);
    }


    public function update(InterestDTO $interesDTO, int|Interest $interes)
    {
        if (is_int($interes))
            $interes = $this->findById($interes);
        return $interes->update($interesDTO->toArray());
    }


    public function destroy(Interest|int $interes): ?bool
    {
        if (is_int($interes))
            $interes = $this->findById($interes);
        return $interes->delete();
    }


    public function changeStatus($id): bool
    {
        $interes = $this->findById($id);
        $interes->status = !$interes->status;
        return $interes->save();
    }

    public function getAll(array $filters = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->getQuery($filters)->withCount(['rozmanas'=>fn($query)=>$query->where('therapist_id',$filters['therapist_id'])])->get();
    }
}
