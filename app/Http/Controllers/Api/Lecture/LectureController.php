<?php

namespace App\Http\Controllers\Api\Lecture;

use App\Enums\ActivationStatus;
use App\Enums\UsersType;
use App\Http\Controllers\Controller;
use App\Http\Resources\LecturesResource;
use App\Services\LectureService;
use Illuminate\Http\Request;

class LectureController extends Controller
{

    public function __construct(public LectureService $lectureService)
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            $withRelations = [];
            $filters = $request->all();
            $filters['user_id'] = $user->id;
            if ($user->type == UsersType::CLIENT->value){
                $filters['status'] = ActivationStatus::ACTIVE->value;
                $withRelations = ['therapist:id,name'];
            }
            $lectures = $this->lectureService->paginateLectures($filters,$withRelations);
            return  LecturesResource::make($lectures);
        }catch (\Exception $exception){
            return apiResponse(message: 'something went wrong',code: 500);
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
