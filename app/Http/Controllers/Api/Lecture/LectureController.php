<?php

namespace App\Http\Controllers\Api\Lecture;

use App\DataTransferObjects\Lecture\LectureDTO;
use App\Enums\ActivationStatus;
use App\Enums\UsersType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lecture\LectureRequest;
use App\Http\Resources\LecturesResource;
use App\Services\LectureService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LectureController extends Controller
{

    public function __construct(public LectureService $lectureService)
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            $withRelations = [];
            $filters = $request->all();

            if ($user->type == UsersType::CLIENT->value) {
                $filters['status'] = ActivationStatus::ACTIVE->value;
                $withRelations = ['therapist:id,name'];
            }
            if ($user->type == UsersType::THERAPIST->value) {
                $filters['therapist_id'] = $user->id;
            }
            $lectures = $this->lectureService->paginateLectures($filters, $withRelations);
            return LecturesResource::collection($lectures);
        } catch (\Exception $exception) {
            return apiResponse(message: 'something went wrong', code: 500);
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(LectureRequest $request)
    {
        try {
            DB::beginTransaction();
            $lectureDTO = LectureDTO::fromRequest($request);
            $this->lectureService->store($lectureDTO);
            DB::commit();
            return apiResponse(message: 'Lecture uploaded successfully');
        } catch (ValidationException $exception) {
            DB::rollBack();
            $mappedErrors = collect($exception->errors())->map(function ($error, $key) {
                return [
                    "key" => $key,
                    "error" => Arr::first($error),
                ];
            })->values()->toArray();
            return response(['message' => __('lang.invalid inputs'), 'errors' => $mappedErrors], 422);

        } catch (\Exception $exception) {
            DB::rollBack();
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
