<?php

namespace App\Services;

use App\DataTransferObjects\ChangePassword\PasswordChangeDTO;
use App\DataTransferObjects\Client\ClientDTO;
use App\DataTransferObjects\User\AdminDTO;
use App\Enums\ActivationStatus;
use App\Enums\UsersType;
use App\Exceptions\NotFoundException;
use App\Exceptions\NotFoundException as NotMatchException;
use App\Filters\UsersFilters;
use App\Models\PasswordResetCode;
use App\Models\Therapist;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserService extends BaseService
{

    public function __construct(private User $model, protected NotificationService $pushNotificationService)
    {

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getQuery(?array $filters = []): ?Builder
    {
        return parent::getQuery($filters)
            ->when(!empty($filters), fn(Builder $builder) => $builder->filter(new UsersFilters($filters)));
    }

    public function datatable(array $filters = []): Builder
    {
        return $this->getQuery(filters: $filters)
            ->with(['roles' => fn($query) => $query->withCount('permissions')]);
    }


    public function storeClient(ClientDTO $clientDTO)
    {
        $userData = $clientDTO->toArray();
        $clientDTO->validate();
        $validator = Validator::make($userData, ['email' => 'unique:users,email', 'phone' => 'unique:users,phone']);
        if ($validator->fails())
            throw new ValidationException($validator);
        return $this->getQuery()->create($userData);
    }

    public function storeAdmin(AdminDTO $adminDTO)
    {
        $adminData = $adminDTO->toArrayExcept(['role_id']);
        $adminDTO->validate();
        $validator = Validator::make($adminData, ['email' => 'unique:users,email', 'phone' => 'unique:users,phone']);
        if ($validator->fails())
            throw new ValidationException($validator);
        $admin = $this->getQuery()->create($adminData);
        $admin->syncRoles($adminDTO->role_id);
    }

    public function UpdateAdmin(User $admin, AdminDTO $adminDTO)
    {
        $adminData = $adminDTO->toFilteredArrayExcept(['role_id']);
        $adminDTO->validate();
        $validator = Validator::make($adminData, ['email' => Rule::unique('users', 'email')->ignore($admin->id), 'phone' => Rule::unique('users', 'phone')->ignore($admin->id)]);
        if ($validator->fails())
            throw new ValidationException($validator);
        $admin->update($adminData);
        $admin->syncRoles($adminDTO->role_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return true
     */

    public function update(ClientDTO $userDTO, $id)
    {
        $user = $this->findById($id);
        $data = $userDTO->toArray();
        if (!isset($data['password']))
            $user->update(Arr::except($data, ['profile_image', 'password']));
        else
            $user->update(Arr::except($data, 'profile_image'));

        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return bool
     */
    public function destroy($id)
    {
        $user = $this->findById($id);
        return $user->delete();
    }

    public function setUserFcmToken(User|Therapist $user, string $fcm_token)
    {
        $user->update(['device_token' => $fcm_token]);
    }

    public function changeImage(User|Therapist $user, $image_file): Model
    {
        $user->clearMediaCollection('profile_image'); // all media in the "profile_image" collection will be deleted
        $user->addMedia($image_file)->toMediaCollection('profile_image');
        return $user;
    }


    /**
     * @throws \Exception
     */
    public function changePassword(User|Therapist $user, PasswordChangeDTO $passwordChangeDTO): bool
    {
        if (!Hash::check($passwordChangeDTO->old_password, $user->password))
            throw new NotMatchException(trans('app.password_not_match'));
        return $user->update([
            'password' => bcrypt($passwordChangeDTO->new_password),
        ]);
    }

    /**
     * @throws NotMatchException
     */
    public function changeStatus($id): bool
    {
        $user = $this->findById($id);
        $user->status = !$user->status;
        $is_updated = $user->save();
        if ($user->status != ActivationStatus::ACTIVE->value)
            $user->tokens()->delete();
        return $is_updated;
    }

    public function search(?array $filters = []): LengthAwarePaginator
    {
        return $this->getQuery($filters)->select(['id', 'name'])->paginate();
    }

    /**
     * @throws NotMatchException
     */
    public function loginWithEmailOrPhone(string $identifier, string $password): User|Model
    {

        $identifierField = is_numeric($identifier) ? 'phone' : 'email';
        $credential = [$identifierField => $identifier, 'password' => $password];
        if (!auth()->attempt($credential))
            throw new NotFoundException(__('app.auth.login_failed'));
        return $this->model->where($identifierField, $identifier)->first();
    }

    /**
     * @throws NotMatchException
     */
    public function phoneVerifyAndSendFcm(string $phone, int $user_type)
    {
        $this->validateBeforeCreate(user_type: $user_type, phone: $phone);
        $code = mt_rand(100000, 999999);
        $token = [];
        PasswordResetCode::query()->where('phone', $phone)->delete();
        $codeData = PasswordResetCode::create(['phone' => $phone, 'code' => $code]);
        if ($user_type == UsersType::CLIENT->value)
            $token = User::query()->where('phone', $phone)
                ->pluck('device_token')->toArray();
        elseif ($user_type == UsersType::THERAPIST->value)
            $token = Therapist::query()->where('phone', $phone)
                ->pluck('device_token')->toArray();

        if (empty($token))
            throw new NotFoundException('device token not provided');

        $title = 'Your OTP Code';
        $body = $codeData->code;
        $this->pushNotificationService->sendToTokens(title: $title, body: $body, tokens: $token);
        return $body;
    }

    public function resetPassword(string $code, string $password, int $user_type)
    {
        $passwordReset = PasswordResetCode::firstWhere('code', $code);
        if ($passwordReset->isExpire())
            return apiResponse(message: __('lang.code_is_expire'), code: 422);

        if ($user_type == UsersType::CLIENT->value)
            $user = User::where('phone', $passwordReset->phone)->first();
        else
            $user = Therapist::where('phone', $passwordReset->phone)->first();

        $is_updated = $user->update(['password' => $password]);

        $passwordReset->delete();

        return $is_updated;
    }

    public function getDeviceTokenForUsers(array $users_id = []): array
    {
        return $this->getQuery(['ids' => $users_id])->pluck('device_token')->toArray();
    }

    private function validateBeforeCreate(int $user_type, string $phone)
    {
        switch ($user_type) {
            case UsersType::THERAPIST->value:
                Validator::validate(['phone' => $phone], [Rule::exists('therapists', 'phone')]);

            case UsersType::CLIENT->value:
                Validator::validate(['phone' => $phone], [Rule::exists('users', 'phone')]);
        }
    }

    public function getToken(int|User $user)
    {
        if (is_int($user)) {
            $user = $this->findById($user);
        }
        return $user->pluck('device_token')->toArray();
    }
}
