<?php

namespace App\Services;

use App\DataTransferObjects\Rozmana\RozmanaDTO;
use App\Exceptions\NotFoundException;
use App\Filters\RozmanaFilter;
use App\Models\Rozmana;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            ->with('interests')
            ->simplePaginate();
    }

    public function datatable(array $filters = []): Builder
    {
        return $this->getQuery(filters: $filters);
    }

    public function create(RozmanaDTO $dto)
    {
        DB::beginTransaction();
        $this->validateBeforeCreate($dto);
        $rozmanaData = $dto->toArrayExcept(['interets']);
        $rozmana = $this->getQuery()->create($rozmanaData);
        $rozmana->interests()->sync($dto->interests);
        DB::commit();
        return $rozmana;
    }

    /**
     * @throws NotFoundException
     */
    public function update(RozmanaDTO $dto, Rozmana|int $rozmana)
    {
        DB::beginTransaction();
        if (is_int($rozmana))
            $rozmana = $this->findById($rozmana);
        $this->validateBeforeUpdate(dto: $dto, rozmana_id: $rozmana->id);
        $rozmana->update($dto->toArray());
        $rozmana->interests()->sync($dto->interests);
        DB::commit();
        return $rozmana;
    }

    public function destroy(Rozmana|int $rozmana)
    {
        if (is_int($rozmana))
            $rozmana = $this->findById($rozmana);
        return $rozmana->delete();
    }

    private function validateBeforeCreate(RozmanaDTO $dto): void
    {
        $dto->validate();
        Validator::validate($dto->toArray(), [
            'date' => Rule::unique('rozmanas')->where('therapist_id', auth()->id()),
        ]);
    }

    private function validateBeforeUpdate(RozmanaDTO $dto, int $rozmana_id): void
    {
        $dto->validate();
        Validator::validate($dto->toArray(), [
            'date' => Rule::unique('rozmanas')->where('therapist_id', auth()->id())->ignore($rozmana_id),
        ]);

    }

    public function changeStatus(int|Rozmana $rozmana): bool
    {
        if (is_int($rozmana))
            $rozmana = $this->findById($rozmana);
        $rozmana->status = !$rozmana->status;
        return $rozmana->save();
    }
}
