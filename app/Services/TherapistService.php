<?php

namespace App\Services;

use App\DataTransferObjects\Therapist\CreateTherapistDTO;
use App\Exceptions\GeneralException;
use App\Exceptions\NotFoundException;
use App\Filters\TherapistFilters;
use App\Filters\UsersFilters;
use App\Http\Requests\Notification\StoreFcmTokenRequest;
use App\Models\Therapist;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class TherapistService extends BaseService
{

    public function __construct(private readonly Therapist $model)
    {

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getQuery(?array $filters = []): ?Builder
    {
        return parent::getQuery($filters)
            ->when(!empty($filters), fn(Builder $builder) => $builder->filter(new TherapistFilters($filters)));
    }

    public function datatable(array $filters = [], array $withRelations = []): Builder
    {
        return $this->getQuery(filters: $filters)->with($withRelations);
    }

    /**
     * @param CreateTherapistDTO $therapistDTO
     * @return Builder|Model|null
     */
    public function store(CreateTherapistDTO $therapistDTO)
    {
        $this->validateBeforeCreate(therapistDTO: $therapistDTO);

        $user = $this->getQuery()->create($therapistDTO->toArray());
        if (isset($therapistDTO->profile_image)) {
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
    public function update(CreateTherapistDTO $therapistDTO, $id)
    {
        $therapist = $this->findById($id);
        $data = array_filter($therapistDTO->toArray());
        $therapist->update($data);
        return $therapist;
    }

    /**
     * @throws NotFoundException
     * @throws GeneralException
     */
    public function changeStatus($id, $status): bool
    {
        $therapist = $this->findById($id);
        if (!isset($status))
            throw new GeneralException('invalid inputs please provide status to update');
        return $therapist->update(['status' => $status]);
    }

    private function validateBeforeCreate(CreateTherapistDTO $therapistDTO): void
    {
        $therapistDTO->validate();
        $therapistData = $therapistDTO->toArray();
        Validator::validate($therapistData, ['email' => 'unique:users,email', 'phone' => 'unique:users,phone']);

    }

    /**
     * @throws NotFoundException
     */
    public function loginWithEmailOrPhone(string $identifier, string $password): Therapist|Model
    {

        $identifierField = is_numeric($identifier) ? 'phone' : 'email';
        $credential = [$identifierField => $identifier, 'password' => $password,];
        if (!auth()->guard('therapist')->attempt($credential))
            throw new NotFoundException(__('app.auth.login_failed'));
        return $this->model->where($identifierField, $identifier)->first();
    }
}
