<?php

namespace Database\Seeders;

use App\Services\RoleService;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionsList = config('permissions');
        $data = [];
        foreach ($permissionsList as $groupName => $permissions) {
            foreach ($permissions as $permission) {
                $data[] = [
                    'name' => $permission,
                    'group' => $groupName,
                    'guard_name' => 'web',
                ];
            }
        }
        Permission::query()->upsert($data, ['name', 'group', 'guard_name'], ['name', 'group', 'guard_name']);
        app()->make(RoleService::class)->createSuperAdminRole();
    }
}
