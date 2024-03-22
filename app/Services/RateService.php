<?php

namespace App\Services;

use getID3;
use getid3_lib;
use App\Models\Rate;
use App\Models\Slider;
use App\Models\Lecture;
use App\Filters\RateFilter;
use App\Models\UserLecture;
use Illuminate\Support\Arr;
use App\Enums\AttachmentsType;
use App\Filters\SlidersFilter;
use App\Filters\LecturesFilter;
use App\Exceptions\GeneralException;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Model;
use App\DataTransferObjects\Rate\RateDTO;
use Illuminate\Database\Eloquent\Builder;

use App\DataTransferObjects\Lecture\LectureDTO;
use App\DataTransferObjects\Lecture\UpdateLectureDTO;
use App\DataTransferObjects\Therapist\CreateTherapistDTO;

class RateService extends BaseService
{

    public function __construct(protected Rate $model)
    {
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getQuery(?array $filters = []): ?Builder
    {
        return parent::getQuery($filters)
            ->when(!empty($filters), fn (Builder $builder) => $builder->filter(new RateFilter($filters)));
    }


    public function datatable(array $filters = []): Builder
    {
        return $this->getQuery(filters: $filters);
    }

    /**
     * @param CreateTherapistDTO $therapistDTO
     * @return Builder|Model|null
     */
    public function store(RateDTO  $rateDTO)
    {
        $rateDTO->validate();
        $rateData =  $rateDTO->toArray();
        $rate = $this->getQuery()->create($rateData);
        return $rate;
    }

    /**
     * @param RateDTO  $rateDTO
     * @param int|Rate $rate
     * @return mixed
     * @throws NotFoundException
     */
    public function update( RateDTO  $rateDTO, int|Rate $rate)
    {
        if (is_int($rate))
        $rate = $this->findById($rate);
        $rateData =  $rateDTO->toFilteredArray();
        return $rate->update($rateData);
    }


    /**
     * @throws NotFoundException
     * @throws GeneralException
     */
    public function destroy(Rate|int $rate): ?bool
    {
        if (is_int($rate))
        $rate = $this->findById($rate);
        return $rate->delete();
    }

}
