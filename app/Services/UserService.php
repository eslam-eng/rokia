<?php

namespace App\Services;

use App\DataTransferObjects\User\UserDTO;
use App\Enums\AttachmentsType;
use App\Models\User;
use App\Filters\UsersFilters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
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

     public function datatable(array $filters = [] , array $withRelations = []): Builder
    {
        return $this->getQuery(filters: $filters)->with($withRelations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserDTO $userDTO)
    {
        $userData = $userDTO->toArray();
        $userDTO->validate();
        $validator = Validator::make($userData,['email'=>'unique:users,email','phone'=>'unique:users,phone']);
        if ($validator->fails())
            throw new ValidationException($validator);
        $user = $this->getQuery()->create($userData);
        if (isset($userDTO->profile_image))
        {
            $user->addMediaFromRequest('profile_image')->toMediaCollection();
        }
        return  $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return true
     */
    public function update(UserDTO $userDTO, $id)
    {
        $user = $this->findById($id);
        $data = $userDTO->toArray();
        if(!isset($data['password']))
            $user->update(Arr::except($data, ['profile_image', 'password']));
        else
            $user->update(Arr::except($data, 'profile_image'));

        if (isset($data['profile_image']))
        {
            $user->deleteAttachmentsLogo();
            $fileData = FileService::saveImage(file: $data['profile_image'],path: 'uploads/users', field_name: 'profile_image');
            $fileData['type'] = AttachmentsType::PRIMARYIMAGE;
            $user->storeAttachment($fileData);
        }
        $user->syncPermissions(Arr::get($data, 'permissions'));
        return true;
    }

    public function updateProfile(array $data = [], $id)
    {
        $user = $this->findById($id);
        if(!isset($data['password']))
            $user->update(Arr::except($data, ['profile_image', 'password']));
        else{
            $data['password'] = bcrypt($data['password']);
            $user->update(Arr::except($data, 'profile_image'));
        }

        if (isset($data['profile_image']))
        {
            $user->deleteAttachmentsLogo();
            $fileData = FileService::saveImage(file: $data['profile_image'],path: 'uploads/users', field_name: 'profile_image');
            $fileData['type'] = AttachmentsType::PRIMARYIMAGE;
            $user->storeAttachment($fileData);
        }
        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return bool
     */
    public function destroy($id)
    {
        $user = $this->findById($id);
        return $user->delete();
    }

    public function setUserFcmToken($fcm_token)
    {
        $user = auth('sanctum')->user();
        $user->update(['device_token' => $fcm_token]);
    }
}
