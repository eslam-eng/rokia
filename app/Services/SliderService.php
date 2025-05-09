<?php

namespace App\Services;

use App\DataTransferObjects\Lecture\LectureDTO;
use App\DataTransferObjects\Lecture\UpdateLectureDTO;
use App\DataTransferObjects\Slider\SliderDTO;
use App\DataTransferObjects\Therapist\CreateTherapistDTO;
use App\Enums\AttachmentsType;
use App\Exceptions\GeneralException;
use App\Exceptions\NotFoundException;
use App\Filters\LecturesFilter;
use App\Filters\SlidersFilter;
use App\Models\Lecture;
use App\Models\Slider;
use App\Models\UserLecture;
use getID3;
use getid3_lib;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class SliderService extends BaseService
{

    public function __construct(protected Slider $model)
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
    public function store(SliderDTO $sliderDTO)
    {
        $sliderDTO->validate();
        $sliderData = $sliderDTO->toArray();
        $slider = $this->getQuery()->create($sliderData);
        if (isset($sliderDTO->image)) {
            $slider->addMediaFromRequest('image')->toMediaCollection('sliders');

        }

        return $slider;
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
