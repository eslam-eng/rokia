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
        $sliderData = $sliderDTO->toArrayExcept(['audio_file']);
        $slider = $this->getQuery()->create($sliderData);
        if (isset($sliderDTO->image)) {
            $slider->addMediaFromRequest('image')->toMediaCollection();
        }

        return $slider;
    }

    /**
     * @param UpdateLectureDTO $lectureDTO
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|Model
     * @throws NotFoundException
     */
    public function update(UpdateLectureDTO $lectureDTO, $id)
    {
        $lecture = $this->findById($id);
        if (!$lecture)
            throw new NotFoundException('lecture not found');
        $lectureDTO->type = $lecture->type;
        $lectureDTO->validate();
        $lectureData = $lectureDTO->toArray();
        $lecture->update($lectureData);
        return $lecture;
    }

    public function changeCoverImage(array $data = [], $id)
    {
        $user = $this->findById($id);
        if (!isset($data['password']))
            $user->update(Arr::except($data, ['profile_image', 'password']));
        else {
            $data['password'] = bcrypt($data['password']);
            $user->update(Arr::except($data, 'profile_image'));
        }

        if (isset($data['profile_image'])) {
            $user->deleteAttachmentsLogo();
            $fileData = FileService::saveImage(file: $data['profile_image'], path: 'uploads/users', field_name: 'profile_image');
            $fileData['type'] = AttachmentsType::PRIMARYIMAGE;
            $user->storeAttachment($fileData);
        }
        return true;
    }


    /**
     * @throws NotFoundException
     * @throws GeneralException
     */
    public function destroy($id): ?bool
    {
        $count_users_for_lecture = UserLecture::query()->where('lecture_id',$id)->count();
        if ($count_users_for_lecture)
            throw new GeneralException('cannot delete lecture there is users already buy it');
        $lecture = $this->findById($id);
        return $lecture->delete();
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
