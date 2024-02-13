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
use Illuminate\Database\Eloquent\Model;
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
     * @return Builder|Model|null
     */
    public function store(TherapistScheduleDTO $therapistScheduleDTO)
    {
        $therapistScheduleDTO->validate();
        Validator::validate($therapistScheduleDTO->toArray(), [
            'day_id' => Rule::unique('therapist_schedules', 'day_id')->where('therapist_id', $therapistScheduleDTO->therapist_id)
        ]);
        $therapistScheduleData = $therapistScheduleDTO->toArray();
        return $this->getQuery()->create($therapistScheduleData);
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

}
