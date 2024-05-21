<?php

namespace App\Services\Therapist;

use App\DataTransferObjects\Therapist\Api\UpdateMainTherapisDatatDTO;
use App\DataTransferObjects\Therapist\Api\UpdateTherapySessionDataDTO;
use App\DataTransferObjects\Therapist\CreateTherapistDTO;
use App\DataTransferObjects\Therapist\UpdateTherapistDTO;
use App\Enums\ActivationStatus;
use App\Exceptions\GeneralException;
use App\Exceptions\NotFoundException;
use App\Filters\TherapistFilters;
use App\Models\Therapist;
use App\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TherapistService extends BaseService
{

    public function __construct(private readonly Therapist $model, protected readonly TherapistScheduleService $therapistScheduleService)
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

    public function paginate(array $filters = [], array $selectedColumns = ['*']): \Illuminate\Contracts\Pagination\Paginator
    {
        return $this->getQuery(filters: $filters)
            ->select($selectedColumns)
            ->simplePaginate();
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
     * @return Collection|Model
     */
    public function update(UpdateTherapistDTO $therapistDTO, Therapist|int $therapist)
    {
        $therapistDTO->validate();
        Validator::validate($therapistDTO->toArray(), [
            'phone' => Rule::unique('therapists', 'phone')->ignore($therapist->id)
        ]);
        if (is_int($therapist)) {
            $therapist = $this->findById($therapist);
        }
        $data = $therapistDTO->toFilteredArray();
        $therapist->update($data);
        return $therapist;
    }

    public function updateProfileData(UpdateMainTherapisDatatDTO $therapistDTO, Therapist|int $therapist)
    {
        $therapistDTO->validate();
        Validator::validate($therapistDTO->toArray(), [
            'phone' => Rule::unique('therapists', 'phone')->ignore($therapist->id)
        ]);
        if (is_int($therapist)) {
            $therapist = $this->findById($therapist);
        }
        $data = $therapistDTO->toFilteredArray();
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

        $is_updated = $therapist->update(['status' => $status]);
        if ($therapist->status != ActivationStatus::ACTIVE->value)
            $therapist->tokens()->delete();
        return $is_updated;
    }

    private function validateBeforeCreate(CreateTherapistDTO $therapistDTO): void
    {
        $therapistDTO->validate();
        $therapistData = $therapistDTO->toArray();
        Validator::validate($therapistData, ['email' => 'unique:therapists,email', 'phone' => 'unique:therapists,phone']);

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

    public function getTherapistDetails(Therapist $therapist): Therapist
    {
        return $therapist->load('specialists');
    }

    public function getTherapistDetailsForClient(Therapist $therapist): Therapist
    {
        return $therapist->load($loadRelations = [
            'specialists',
            'lectures' => fn($query) => $query->with('rates.user')->withAvg('rates','rate_number'),
            'schedules'
        ]);
    }

    public function getSchedules($therapist_id): Collection|array
    {
        return $this->therapistScheduleService->getSchedulesByTherapist(therapist_id: $therapist_id);
    }

    public function search(?array $filters = []): LengthAwarePaginator
    {
        return $this->getQuery($filters)->select(['id', 'name'])->paginate();
    }

    public function updateTherapySessionData(UpdateTherapySessionDataDTO $therapySessionDataDTO, Therapist $therapist): Therapist
    {
        //first update specialists
        DB::beginTransaction();
        $therapist->specialists()->sync($therapySessionDataDTO->specialists);
        $therapistSessionData = $therapySessionDataDTO->toArrayExcept(['specialists']);
        $therapist->update($therapistSessionData);
        DB::commit();
        return $therapist;

    }

    public function getToken(int|Therapist $therapist)
    {
        if (is_int($therapist)) {
            $therapist = $this->findById($therapist);
        }
        return $therapist->pluck('device_token')->toArray();
    }
}
