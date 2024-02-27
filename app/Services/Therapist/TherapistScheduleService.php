<?php

namespace App\Services\Therapist;

use App\DataTransferObjects\Therapist\CreateTherapistDTO;
use App\DataTransferObjects\TherapistSchedule\TherapistScheduleDTO;
use App\Exceptions\GeneralException;
use App\Exceptions\NotFoundException;
use App\Exceptions\TherapistScheduleException;
use App\Filters\TherapistScheduleFilters;
use App\Models\Therapist;
use App\Models\TherapistSchedule;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class TherapistScheduleService extends BaseService
{

    public function __construct(protected TherapistSchedule $model)
    {

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getQuery(?array $filters = []): ?Builder
    {
        return parent::getQuery($filters)
            ->when(!empty($filters), fn(Builder $builder) => $builder->filter(new TherapistScheduleFilters($filters)));
    }


    public function datatable(array $filters = []): Builder
    {
        return $this->getQuery(filters: $filters);
    }

    /**
     * @param CreateTherapistDTO $therapistDTO
     * @return bool
     * @throws TherapistScheduleException
     */
    public function store(TherapistScheduleDTO $therapistScheduleDTO,Therapist $therapist)
    {
        $therapistScheduleDTO->validate();
        if (!isset($therapist->therapy_price))
            throw new TherapistScheduleException();
        $schedules = $therapistScheduleDTO->schedules;
        $inseredData = [];
        foreach ($schedules as $schedule) {
            $inseredData[] = [
                'day_id' => $therapistScheduleDTO->day_id,
                'therapist_id' => $therapistScheduleDTO->therapist_id,
                'start_time' => Arr::get($schedule, 'start_time'),
                'end_time' => Arr::get($schedule, 'end_time'),
            ];
        }
        return $this->getQuery()->insert($inseredData);
    }

    /**
     * @throws NotFoundException
     * @throws GeneralException
     */
    public function destroy(TherapistSchedule|int $therapistSchedule): ?bool
    {
        if (is_int($therapistSchedule))
            $therapistSchedule = $this->findById($therapistSchedule);
        return $therapistSchedule->delete();
    }

    public function getSchedulesByTherapist(int $therapist_id): Collection|array
    {
        return $this->getQuery(['therapist_id' => $therapist_id])
            ->with(['therapist'=>function ($query) {
                $query->select(['id','avg_therapy_duration'])->with('appointments:id,therapist_id,day_id,time,date');
            }])->get();
    }

}
