<?php

namespace App\Services;

use App\DataTransferObjects\Role\RoleDTO;
use App\Enums\ActivationStatus;
use App\Exceptions\NotFoundException;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RoleService extends BaseService
{
    public function __construct(protected Role $role)
    {
    }

    public function getModel(): Role|Model
    {
        return $this->role;
    }

    public function datatable(array $filters = []): ?Builder
    {
        return $this
            ->getQuery(filters: $filters)
            ->withCount(['users', 'permissions']);
    }

    public function create(RoleDTO $roleDTO): Builder|Model|Role
    {
        $this->validateBeforeCreate($roleDTO);
        $data = $roleDTO->toArray();

        return $this->getQuery()->create($data);
    }

    public function createSuperAdminRole(): Model|Builder|Role
    {
        return $this->getQuery()
            ->updateOrCreate(
                ['name' => Role::SUPER_ADMIN],
                [
                    'guard_name' => 'web',
                    'is_active' => ActivationStatus::ACTIVE->value,
                ]
            );
    }


    public function update(Role $role, RoleDTO $roleDTO)
    {
        $this->validateBeforeUpdate($role->id, $roleDTO);
        $data = $roleDTO->toArray();

        return $role->update($data);
    }

    /**
     * @throws NotFoundException
     * @throws \Exception
     */
    public function delete(Role|int $role): ?bool
    {
        $this->validateBeforeDelete($role);
        if (is_int($role)) {
            $role = parent::findById($role);
        }

        return $role->delete();
    }

    private function validateBeforeCreate($dto): void
    {
        $dto->validate();
        Validator::validate(
            $dto->toArray(),
            [
                'name' => Rule::unique('roles', 'name'),
            ]
        );
    }

    private function validateBeforeUpdate(int $id, RoleDTO $dto): void
    {
        $dto->validate();
        Validator::validate(
            $dto->toArray(),
            [
                'name' => Rule::unique('roles')->ignore($id),
            ]
        );
    }

    /**
     * @throws \Exception
     */
    private function validateBeforeDelete(Role|int $role): void
    {
        if (is_int($role)) {
            $role = parent::findById($role);
        }

        //prevent deleting role if its name is super admin
        if ($role->name == Role::SUPER_ADMIN) {
            throw new \Exception('You cannot delete super admin role', 400);
        }
    }

    public function assignPermissionsToRole(Role $role, array $permissions): array
    {
        $this->validateBeforeAssign($permissions);

        return $role->permissions()->sync($permissions);
    }

    private function validateBeforeAssign(array $permissions): void
    {
        Validator::validate($permissions, [
            '*' => Rule::exists('permissions', 'id'),
        ]);
    }
}
