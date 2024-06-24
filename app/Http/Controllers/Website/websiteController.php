<?php

namespace App\Http\Controllers\Website;


use App\DataTables\Clients\ClientsDataTable;
use App\Enums\UsersType;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class websiteController extends Controller
{

    public function index()
    {
        return view('website.index');
    }

    public function contactUs(Request $request)
    {
       $request->validate([
           'name' => 'required',
           'email' => 'required|email',
           'phone' => 'required',
           'message' => 'required',
       ]);
       return back()->with('success', 'Thanks for contacting us!');
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
