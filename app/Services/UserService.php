<?php

namespace App\Services;

use App\DataTransferObjects\ChangePassword\PasswordChangeDTO;
use App\DataTransferObjects\User\UserDTO;
use App\Exceptions\NotFoundException;
use App\Exceptions\NotFoundException as NotMatchException;
use App\Filters\UsersFilters;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserService extends BaseService
{

    public function __construct(private User $model)
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

    public function setUserFcmToken($fcm_token, User $user)
    {
        $user->update(['device_token' => $fcm_token]);
    }

    public function changeImage(User $user,$image_file): User
    {
            $user->clearMediaCollection(); // all media in the "default" collection will be deleted
            $user->addMedia($image_file)->toMediaCollection();
            return $user;
    }


    /**
     * @throws \Exception
     */
    public function changePassword(User $user, PasswordChangeDTO $passwordChangeDTO): bool
    {
        if (!Hash::check($passwordChangeDTO->old_password, $user->password))
            throw new NotMatchException(trans('app.password_not_match'));
        return $user->update([
            'password' => bcrypt($passwordChangeDTO->new_password),
        ]);
    }

    public function changeStatus($id): bool
    {
        $slider = $this->findById($id);
        if (!$slider)
            throw new NotFoundException('user not found');
        $slider->status = !$slider->status ;
        return $slider->save();
    }
}
