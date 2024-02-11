<?php

namespace App\Http\Controllers;

use App\DataTables\Roles\RolesDatatable;
use App\DataTransferObjects\Role\RoleDTO;
use App\Http\Requests\Role\RoleRequest;
use App\Models\Role;
use App\Services\RoleService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct(public RoleService $roleService)
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(RolesDatatable $datatable, Request $request)
    {
        $filters = $request->get('filters', []);
        return $datatable->with(['filters' => $filters])->render('layouts.dashboard.system.role.index');
    }


    public function create()
    {
        $permissions = Permission::query()->get()->groupBy('group', true);
        return view('layouts.dashboard.system.role.form', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store(RoleRequest $request)
    {
        try {
            DB::beginTransaction();
            $roleDTO = RoleDTO::fromRequest($request);
            $roleDTO->guard_name = 'web';
            $role = $this->roleService->create($roleDTO);

            $permissions = $request->get('permissions');
            $this->roleService->assignPermissionsToRole($role, $permissions);
            DB::commit();
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'Successfully Created!'];

            return redirect()->route('role.index')->with('toast', $toast);
        } catch (Exception $exception) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $exception->getMessage()];

            DB::rollBack();

            return back()->with('toast', $toast);
        }
    }

    public function edit(Role $role)
    {
        $role->loadMissing('permissions');
        $role_permissions = $role->permissions->pluck('id')->toArray();
        $permissions = Permission::query()->get()->groupBy('group', true);
        return view('layouts.dashboard.system.role.form', compact('role', 'permissions', 'role_permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return RedirectResponse|void
     */
    public function update(RoleRequest $request, Role $role)
    {
        try {
            DB::beginTransaction();
            $roleDTO = RoleDTO::fromRequest($request);
            $this->roleService->update($role, $roleDTO);
            $permissions = $request->get('permissions');
            $this->roleService->assignPermissionsToRole($role, $permissions);
            DB::commit();
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'Successfully updated!'];
            return redirect(route('role.index'))->with('toast', $toast);

        } catch (Exception $exception) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $exception->getMessage()];
            return back()->with('toast', $toast);
        }
    }

    public function destroy(Role $role)
    {
        try {
            $this->roleService->delete(role: $role);
            return apiResponse(message: 'Role deleted successfully');
        } catch (Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }


}
