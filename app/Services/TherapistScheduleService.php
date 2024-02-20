<?php

namespace App\Services;

use App\DataTransferObjects\Slider\SliderDTO;
use App\DataTransferObjects\Therapist\CreateTherapistDTO;
use App\DataTransferObjects\TherapistSchedule\TherapistScheduleDTO;
use App\Exceptions\GeneralException;
use App\Exceptions\NotFoundException;
use App\Filters\TherapistScheduleFilters;
use App\Models\Slider;
use App\Models\TherapistSchedule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
     */
    public function store(TherapistScheduleDTO $therapistScheduleDTO)
    {
        $therapistScheduleDTO->validate();
        $scheduleData = $therapistScheduleDTO->toArray();
        $inseredData = [];
        foreach ($scheduleData as $schedule) {
            $inseredData[] = [
                'day_id' => $therapistScheduleDTO->day_id,
                'therapist_id' => $therapistScheduleDTO->therapist_id,
                'start_time' => Arr::get($schedule, 'start_time'),
                'end_time' => Arr::get($schedule, 'end_time'),
            ];
        }
        $stringifiedArrays = array_map('serialize', $inseredData);
        // Remove duplicate stringified arrays
        $uniqueStringifiedArrays = array_unique($stringifiedArrays);
        // Convert the unique stringified arrays back to arrays
        $therapistScheduleData = array_map('unserialize', $uniqueStringifiedArrays);

        return $this->getQuery()->insert($therapistScheduleData);
    }

    /**
     * @param SliderDTO $sliderDTO
     * @param int|Slider $slider
     * @return mixed
     * @throws NotFoundException
     */
    public function update(SliderDTO $sliderDTO, int|Slider $slider)
    {
        if (is_int($slider))
            $slider = $this->findById($slider);

        $sliderData = $sliderDTO->toFilteredArray();

        if (isset($sliderData['image'])) {
            //first remove the old
            $slider->clearMediaCollection('sliders');
            //second add new image
            $slider->addMediaFromRequest('image')->toMediaCollection('sliders');
        }
        return $slider->update($sliderData);
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
            ->with('therapist:id,avg_therapy_duration')->get();
    }

}
