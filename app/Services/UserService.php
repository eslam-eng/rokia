<?php

namespace App\Services;

use App\DataTransferObjects\ChangePassword\PasswordChangeDTO;
use App\DataTransferObjects\User\UserDTO;
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
use Illuminate\Validation\ValidationException;

class UserService extends BaseService
{

    public function __construct(private User $model, protected PushNotificationService $pushNotificationService)
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
            ->withCount('lecture');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserDTO $userDTO)
    {
        $userData = $userDTO->toArray();
        $userDTO->validate();
        $validator = Validator::make($userData, ['email' => 'unique:users,email', 'phone' => 'unique:users,phone']);
        if ($validator->fails())
            throw new ValidationException($validator);
        $user = $this->getQuery()->create($userData);
        if (isset($userDTO->profile_image)) {
            $user->clearMediaCollection(); // all media in the "default" collection will be deleted
            $user->addMediaFromRequest('profile_image')->toMediaCollection();
        }
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return true
     */
    public function update(UserDTO $userDTO, $id)
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
        $user->clearMediaCollection(); // all media in the "default" collection will be deleted
        $user->addMedia($image_file)->toMediaCollection();
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
        return $user->save();
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
        $credential = [$identifierField => $identifier, 'password' => $password,];
        if (!auth()->attempt($credential))
            throw new NotFoundException(__('app.auth.login_failed'));
        return $this->model->where($identifierField, $identifier)->first();
    }

    /**
     * @throws NotMatchException
     */
    public function phoneVerifyAndSendFcm(string $phone, int $user_type)
    {
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

        $is_updated =  $user->update(['password' => $password]);

        $passwordReset->delete();

        return $is_updated;
    }

    public function getDeviceTokenForUsers(array $users_id = []): array
    {
        return $this->getQuery(['ids'=>$users_id])->pluck('device_token')->toArray();
    }
}
