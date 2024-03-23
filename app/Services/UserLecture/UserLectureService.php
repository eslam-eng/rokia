<?php

namespace App\Services\UserLecture;

use App\DataTransferObjects\Lecture\BuyLectureDTO;
use App\Enums\PaymentStatusEnum;
use App\Exceptions\NotFoundException;
use App\Filters\LecturesFilter;
use App\Models\UserLecture;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UserLectureService extends BaseService
{

    public function __construct(protected UserLecture $model)
    {

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function destroy($user_lecture_id): ?bool
    {
        return $this->getQuery()->where('id', $user_lecture_id)->delete();
    }

    public function getQuery(?array $filters = []): ?Builder
    {
        return parent::getQuery($filters)
            ->when(!empty($filters), fn(Builder $builder) => $builder->filter(new LecturesFilter($filters)));
    }

    /**
     * @throws NotFoundException
     */
    public function confirmPaymentStatus(array $userLectureData = []): bool
    {
        $userLecture = $this->findById(Arr::get($userLectureData, 'merchant_id'));
        $userLectureUpdatedData = ['transaction_id'=> Arr::get($userLectureData, 'transaction_id'), 'payment_status' => PaymentStatusEnum::PAID->value];
        return $userLecture->update($userLectureUpdatedData);
    }

    public function buyLecture(BuyLectureDTO $buyLectureDTO)
    {
        $buyLectureDTO->validate();
        $userLectureData = $buyLectureDTO->toArray();
        return $this->getQuery()->create($userLectureData);
    }
}
