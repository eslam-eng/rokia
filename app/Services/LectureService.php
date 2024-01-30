<?php

namespace App\Services;

use App\DataTransferObjects\Lecture\LectureDTO;
use App\DataTransferObjects\Lecture\UpdateLectureDTO;
use App\DataTransferObjects\Therapist\CreateTherapistDTO;
use App\Exceptions\GeneralException;
use App\Exceptions\NotFoundException;
use App\Filters\LecturesFilter;
use App\Models\Lecture;
use App\Models\User;
use App\Models\UserLecture;
use getID3;
use getid3_lib;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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

    public function getTherapistLectures(array $filters = [], array $withRelations = [], bool $load_scope_date = false): \Illuminate\Contracts\Pagination\Paginator
    {
        return $this->getQuery(filters: $filters)
            ->orderByDesc('id')
            ->simplePaginate();
    }

    //this for users type
    public function getAllLectureForUser($filters)
    {
        return $this->getQuery(filters: $filters)
            ->select('lectures.*')
            ->orderByDesc('id')
            ->with('therapist:id,name')
            ->subscribeUsers()
            ->favorites()
            ->simplePaginate();
    }

    public function datatable(array $filters = [], array $withRelations = []): Builder
    {
        $withRelations = array_merge($withRelations, ['therapist']);
        return $this->getQuery(filters: $filters)
            ->withCount('users')
            ->with($withRelations);
    }

    /**
     * @param CreateTherapistDTO $therapistDTO
     * @return Builder|Model|null
     */
    public function store(LectureDTO $lectureDTO)
    {
        $lectureDTO->validate();
        $lectureData = $lectureDTO->toArrayExcept(['audio_file']);
        $lecture = $this->getQuery()->create($lectureData);
        if (isset($lectureDTO->image_cover)) {
            $lecture->addMediaFromRequest('image_cover')->withCustomProperties(['type' => 'image'])->toMediaCollection();
        }
        if (isset($lectureDTO->audio_file)) {
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

    /**
     * @throws NotFoundException
     * @throws GeneralException
     */
    public function destroy($id): ?bool
    {
        $count_users_for_lecture = UserLecture::query()->where('lecture_id', $id)->count();
        if ($count_users_for_lecture)
            throw new GeneralException('cannot delete lecture there is users already buy it');
        $lecture = $this->findById($id);
        return $lecture->delete();
    }


    public function changeStatus($id, $status): bool
    {
        $lecture = $this->findById($id);
        if (!$lecture)
            throw new NotFoundException('therapist not found');
        if (!isset($status))
            throw new GeneralException('invalied inputs please provide status to update');
        return $lecture->update(['status' => $status]);
    }

    public function getLecturesForUser(User $user): \Illuminate\Database\Eloquent\Collection
    {
        return $user->lecture()->get();
    }

    public function getReportForTherapist(array $filters = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->getQuery($filters)->withCount('users')->paginate(20);
    }
}
