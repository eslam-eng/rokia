<?php

namespace App\Http\Controllers;


use App\DataTables\Clients\ClientsDataTable;
use App\DataTables\Users\UsersDataTable;
use App\Enums\UsersType;
use App\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{

    public function __construct(private UserService $userService)
    {

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

        $filters['type'] = [UsersType::SUPERADMIN->value, UsersType::EMPLOYEE->value];

        return $usersDatatable->with(['filters' => $filters])->render('layouts.dashboard.clients.index');
    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

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
