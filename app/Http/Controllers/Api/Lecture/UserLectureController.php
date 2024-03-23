<?php

namespace App\Http\Controllers\Api\Lecture;

use App\DataTransferObjects\Lecture\BuyLectureDTO;
use App\DataTransferObjects\Lecture\LectureDTO;
use App\Exceptions\NotPaidLectureException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lecture\BuyLectureRequest;
use App\Http\Requests\Lecture\ConfirmLecturePaymentRequest;
use App\Http\Requests\Payment\ConfirmPaymentRequest;
use App\Http\Resources\Lecture\LecturesResource;
use App\Services\LectureService;
use App\Services\UserLecture\UserLectureService;
use App\Traits\NotifyUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UserLectureController extends Controller
{
    use NotifyUsers;
    public function __construct(public LectureService $lectureService,protected UserLectureService $userLectureService)
    {
    }

    public function index()
    {
        try {
            $user = auth()->user();
            $user_lecture =$this->lectureService->getLecturesForUser($user);
            return LecturesResource::collection($user_lecture);
        } catch (\Exception $exception) {
            return apiResponse(message: 'there is an error please try again later', code: 500);
        }
    }

    public function buyLecture(BuyLectureRequest $request)
    {
        try {
            DB::beginTransaction();
            $lecture = $this->lectureService->findById(id: $request->lecture_id,withRelations: ['therapist:id,name']);
            if (!$lecture->is_paid)
                throw new NotPaidLectureException();
            $buyLectureDTO = BuyLectureDTO::fromRequest($request);
            $buyLectureDTO->lecture_data = $lecture->toJson();
            $userLecture = $this->userLectureService->buyLecture(buyLectureDTO: $buyLectureDTO);
            $therapist_name = $lecture->therapist->name;
            $title = " جاري تأكيد شراء المحاضره ";
            $content = "$therapist_name للشيخ  $lecture->title عنوان المحاضرة ";
            $this->notifyUsers(title: $title , content: $content);
            DB::commit();
            return apiResponse(data:['merchant_id'=>$userLecture->id],message: __('app.lectures.buy_lecture_in_progress'));
        } catch (ValidationException $exception) {
            DB::rollBack();
            $mappedErrors = transformValidationErrors($exception->errors());
            return response(['message' => __('lang.invalid inputs'), 'errors' => $mappedErrors], 422);
        }
        catch (NotPaidLectureException $exception) {
            return response(['message' => __('lang.invalid inputs'), 'errors' => $exception->getMessage()], 422);
        }
        catch (\Exception $exception) {
            DB::rollBack();
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    public function confirmLecturePayment(ConfirmPaymentRequest $request)
    {
        try {
            $userLectureData = $request->validated();
            $this->userLectureService->confirmPaymentStatus($userLectureData);
            return apiResponse(message: __('app.general.success_operation'));
        }catch (\Exception $exception)
        {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }
}
