<?php

namespace App\Http\Controllers;


use App\DataTables\clients\UsersDataTable;
use App\Enums\UsersType;
use App\Exceptions\NotFoundException;
use App\Http\Requests\FileUploadRequest;
use App\Http\Requests\Users\ClientRequest;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class UsersController extends Controller
{

    public function __construct(private UserService $userService)
    {

    }

    /**
     * @param UsersDataTable $usersDatatable
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function index(UsersDataTable $usersDatatable, Request $request)
    {
        try {
            $filters = array_filter($request->get('filters', []), function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });

            $filters['type'] = UsersType::CLIENT->value;

            return $usersDatatable->with(['filters' => $filters])->render('layouts.dashboard.users.index');
        } catch (Exception $e) {
            $toast = [
                'type' => 'error',
                'title' => 'error',
                'message' => $e->getMessage()
            ];
            return back()->with('toast', $toast);
        }
    }
}
