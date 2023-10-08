<?php

namespace App\Services;

use App\DataTransferObjects\Therapist\TherapistDTO;
use App\Enums\AttachmentsType;
use App\Exceptions\GeneralException;
use App\Exceptions\NotFoundException;
use App\Filters\LecturesFilter;
use App\Models\Lecture;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
        return $this->getQuery(filters: $filters)->with($withRelations)->orderByDesc('id')->simplePaginate(10);
    }

    public function datatable(array $filters = [], array $withRelations = []): Builder
    {
        return $this->getQuery(filters: $filters)->with($withRelations);
    }

    /**
     * @param TherapistDTO $therapistDTO
     * @return Builder|Model|null
     */
    public function store(TherapistDTO $therapistDTO)
    {
        $therapistData = $therapistDTO->toArray();
        $therapistDTO->validate();
        $validator = Validator::make($therapistData, ['email' => 'unique:users,email', 'phone' => 'unique:users,phone']);
        if ($validator->fails())
            throw new ValidationException($validator);
        $user = $this->getQuery()->create($therapistData);
        if (isset($therapistDTO->profile_image)) {
            $user->addMediaFromRequest('profile_image')->toMediaCollection();
        }
        if (isset($therapistDTO->documents)) {
            foreach ($therapistDTO->documents as $document)
                $user->addMediaFromRequest('profile_image')->toMediaCollection();
        }
        return $user;
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
