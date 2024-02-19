<?php

namespace App\Http\Controllers;


use App\DataTables\Clients\ClientsDataTable;
use App\DataTables\Users\UsersDataTable;
use App\DataTransferObjects\User\AdminDTO;
use App\Enums\UsersType;
use App\Http\Requests\Users\AdminRequest;
use App\Http\Requests\Users\AdminUpdateRequest;
use App\Models\User;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{

    public function __construct(private UserService $userService, public RoleService $roleService)
    {
        //todo make polices as best practice
        $this->middleware('auth');
        $this->middleware(['permission:list_users'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:create_users'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:edit_users'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:delete_users'], ['only' => ['destroy']]);
        $this->middleware(['permission:change_users_status'], ['only' => ['status']]);

    }

    /**
     * @param ClientsDataTable $usersDatatable
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function index(UsersDataTable $usersDatatable, Request $request)
    {
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });

        $filters['type'] = [UsersType::ADMIN->value];

        return $usersDatatable->with(['filters' => $filters])->render('layouts.dashboard.system.admin.index');
    }

    public function create()
    {
        $roles = $this->roleService->getAll();
        return view('layouts.dashboard.system.admin.form', ['roles' => $roles]);
    }

    public function store(AdminRequest $request)
    {
        try {
            DB::beginTransaction();
            $adminDTO = AdminDTO::fromRequest($request);
            $this->userService->storeAdmin(adminDTO: $adminDTO);
            DB::commit();
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'created successfully'];
            return back()->with('toast', $toast);
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $toast = ['type' => 'error', 'title' => 'Success', 'message' => $exception->getMessage()];
            return back()->with('toast', $toast);
        }

    }

    public function edit(User $user)
    {
        $roles = $this->roleService->getAll();
        return view('layouts.dashboard.system.admin.form', ['user' => $user, 'roles' => $roles]);
    }

    public function update(User $user, AdminUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            $adminDTO = AdminDTO::fromRequest($request);
            $this->userService->UpdateAdmin(admin: $user, adminDTO: $adminDTO);
            DB::commit();
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'Updated successfully'];
            return redirect(route('users.index'))->with('toast', $toast);
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $toast = ['type' => 'error', 'title' => 'Success', 'message' => $exception->getMessage()];
            return back()->with('toast', $toast);
        }

    }

    public function destroy(User $user)
    {
        try {
            $this->userService->destroy(id: $user->id);
            return apiResponse(message: 'deleted successfully');
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }


    public function status($id)
    {
        try {
            $this->userService->changeStatus(id: $id);
            return apiResponse(message: __('app.clients.status_changed_successfully'));
        } catch (NotFoundHttpException $exception) {
            return apiResponse(message: __('app.clients.not_found'), code: 404);
        } catch (\Mockery\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $filters = [
            'keyword' => $keyword,
            'type' => $request->get('type', UsersType::CLIENT->value),
        ];

        return $this->userService->search(filters: $filters);
    }
}
