<?php

namespace App\Services\Appointment;

use App\DataTransferObjects\BookAppointment\BookAppointmentDTO;
use App\DataTransferObjects\Slider\SliderDTO;
use App\DataTransferObjects\Therapist\CreateTherapistDTO;
use App\Enums\AttachmentsType;
use App\Exceptions\GeneralException;
use App\Exceptions\NotFoundException;
use App\Filters\SlidersFilter;
use App\Models\BookAppointment;
use App\Models\Slider;
use App\Services\BaseService;
use App\Services\TherapistService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BookAppointmentService extends BaseService
{

    public function __construct(protected BookAppointment $model)
    {

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getQuery(?array $filters = []): ?Builder
    {
        return parent::getQuery($filters)
            ->when(!empty($filters), fn(Builder $builder) => $builder->filter(new SlidersFilter($filters)));
    }


    public function datatable(array $filters = []): Builder
    {
        return $this->getQuery(filters: $filters);
    }

    /**
     * @param CreateTherapistDTO $therapistDTO
     * @return Builder|Model|null
     */
    public function store(BookAppointmentDTO $bookAppointmentDTO)
    {
        $bookAppointmentDTO->validate();
        $bookAppointmentDate = $bookAppointmentDTO->toArray();
        return $this->getQuery()->create($bookAppointmentDate);
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
    public function destroy(Slider|int $slider): ?bool
    {
        if (is_int($slider))
            $slider = $this->findById($slider);
        return $slider->delete();
    }


    public function changeStatus($id): bool
    {
        $slider = $this->findById($id);
        if (!$slider)
            throw new NotFoundException('therapist not found');
        $slider->status = !$slider->status ;
        return $slider->save();
    }
}
