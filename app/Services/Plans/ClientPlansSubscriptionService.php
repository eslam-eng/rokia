<?php

namespace App\Services\Plans;

use App\DataTransferObjects\TherapistPlans\TherapistPlansDTO;
use App\Exceptions\NotFoundException;
use App\Filters\ClientPlansSubscriptionFilter;
use App\Filters\TherapistPlansFilter;
use App\Models\ClientPlanSubscription;
use App\Models\TherapistPlan;
use App\Services\BaseService;
use App\Services\RozmanaService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClientPlansSubscriptionService extends BaseService
{

    public function __construct(protected ClientPlanSubscription $model,public RozmanaService $rozmanaService)
    {

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getQuery(?array $filters = []): ?Builder
    {
        return parent::getQuery($filters)
            ->when(!empty($filters), fn(Builder $builder) => $builder->filter(new ClientPlansSubscriptionFilter($filters)));
    }


    public function datatable(array $filters = []): Builder
    {
        return $this->getQuery(filters: $filters);
    }

    public function store(TherapistPlansDTO $therapistPlansDTO)
    {
        DB::beginTransaction();
        $therapistPlansDTO->validate();
        $therapistPlansData = $therapistPlansDTO->toArrayExcept(['interests']);
        $therapistPlan = $this->getQuery()->create($therapistPlansData);
        $therapistPlan->interests()->sync($therapistPlansDTO->interests);
        DB::commit();
    }


    /**
     * @throws NotFoundException
     */
    public function update(TherapistPlansDTO $therapistPlansDTO, int|TherapistPlan $therapistPlan)
    {
        DB::beginTransaction();
        if (is_int($therapistPlan))
            $therapistPlan = $this->findById($therapistPlan);
        $therapistPlanObject = $therapistPlan;
        $therapistPlan->update($therapistPlansDTO->toArrayExcept(['interests']));
        $therapistPlanObject->interests()->sync($therapistPlansDTO->interests);
        DB::commit();
    }


    public function destroy(int|TherapistPlan $therapistPlan): ?bool
    {
        if (is_int($therapistPlan))
            $therapistPlan = $this->findById($therapistPlan);
        $therapistPlan->interests()->delete();
        return $therapistPlan->delete();
    }


    public function changeStatus(int|TherapistPlan $therapistPlan): bool
    {
        if (is_int($therapistPlan))
            $therapistPlan = $this->findById($therapistPlan);
        $therapistPlan->status = !$therapistPlan->status;
        return $therapistPlan->save();
    }

    public function getAll(array $filters = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->getQuery($filters)->get();
    }

    public function getNotificationForClientByTherapistPlan(TherapistPlan $therapistPlan)
    {

    }
}
