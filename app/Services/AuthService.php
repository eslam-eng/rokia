<?php

namespace App\Services;

use App\Enums\ActivationStatus;
use App\Exceptions\NotFoundException;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseService
{

    public function __construct(public User $model)
    {
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @throws NotFoundException
     */
    public function loginWithEmailOrPhone(string $identifier, string $password): User|Model
    {

        $identifierField = is_numeric($identifier) ? 'phone' : 'email';
        $credential = [$identifierField => $identifier, 'password' => $password , 'status'=>ActivationStatus::ACTIVE()];
        if (!auth()->attempt($credential))
             throw new NotFoundException(__('app.login_failed'));
        return $this->model->where($identifierField, $identifier)->first();
    }


    /**
     * delete existing user
     * @param int $id
     * @return bool
     * @throws NotFoundException
     */
    public function destroy(User $user): bool
    {
        $user->delete();
        return true;
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }


}
