<?php

namespace App\Services;

use App\DataTransferObjects\Lecture\LectureDTO;
use App\DataTransferObjects\Therapist\TherapistDTO;
use App\Enums\AttachmentsType;
use App\Exceptions\GeneralException;
use App\Exceptions\NotFoundException;
use App\Filters\LecturesFilter;
use App\Models\Lecture;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use getID3;
use getid3_lib;

class LectureService extends BaseService
{

    public function __construct(protected Lecture $model)
    {

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getQuery(?array $filters = []): ?Builder
    {
        return parent::getQuery($filters)
            ->when(!empty($filters), fn(Builder $builder) => $builder->filter(new LecturesFilter($filters)));
    }

    public function paginateLectures(array $filters = [], array $withRelations = []): \Illuminate\Contracts\Pagination\Paginator
    {
        return $this->getQuery(filters: $filters)->with($withRelations)->simplePaginate();
    }

    public function datatable(array $filters = [], array $withRelations = []): Builder
    {
        return $this->getQuery(filters: $filters)->with($withRelations);
    }

    /**
     * @param TherapistDTO $therapistDTO
     * @return Builder|Model|null
     */
    public function store(LectureDTO $lectureDTO)
    {
        $lectureDTO->validate();
        $lectureData = $lectureDTO->toArray();
        $lecture = $this->getQuery()->create($lectureData);
        if (isset($lectureDTO->image_cover)) {
            $lecture->addMediaFromRequest('image_cover')->withCustomProperties(['type' => 'image'])->toMediaCollection();
        }
        if (isset($lectureDTO->audio_file)){
            // Initialize getID3
            $getID3 = new getID3;

            $filePath = $lectureDTO->audio_file->getPathname();
            // Analyze the audio file
            $audioInfo = $getID3->analyze($filePath);

            // Get the audio duration in seconds
            $duration = $audioInfo['playtime_seconds'];

            // Format the duration as needed (e.g., convert to minutes and seconds)
            $formattedDuration = getid3_lib::PlaytimeString($duration);

            //save duration in lecture
            $lecture->duration = $formattedDuration;
            $lecture->save();
            $lecture->addMediaFromRequest('audio_file')->withCustomProperties(['type' => 'mp3'])->toMediaCollection();
        }
        return $lecture;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Collection|Model
     */
    public function update(TherapistDTO $therapistDTO, $id)
    {
        $therapist = $this->findById($id);
        $data = array_filter($therapistDTO->toArray());
        $therapist->update($data);
        if (isset($therapistDTO->documents)) {
            foreach ($therapistDTO->documents as $document) {
                $therapist->addMedia($document)->toMediaCollection();
            }
        }
        return $therapist;
    }

    public function updateProfile(array $data = [], $id)
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
    public function changeStatus($id, $status): bool
    {
        $therapist = $this->findById($id);
        if (!$therapist)
            throw new NotFoundException('therapist not found');
        if (!isset($status))
            throw new GeneralException('invalied inputs please provide status to update');
        return $therapist->update(['status' => $status]);
    }
}
