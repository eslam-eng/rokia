<?php

namespace App\Services;

use App\DataTransferObjects\ChangePassword\PasswordChangeDTO;
use App\DataTransferObjects\Client\ClientDTO;
use App\Enums\ActivationStatus;
use App\Enums\LecturesTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Exceptions\NotFoundException as NotMatchException;
use App\Filters\UsersFilters;
use App\Models\Lecture;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DashboardService extends BaseService
{
    public static function statistics()
    {
        //todo set this in cach remember

        $lectures = Lecture::query()->get();

        $data['users_count'] = User::query()->count();
        $data['lectures_count'] = $lectures->count();
        $data['active_lectures_count'] = $lectures->where('status',ActivationStatus::ACTIVE->value)->count();
        $data['not_active_lectures_count'] =$lectures->where('status','!=',ActivationStatus::ACTIVE->value)->count();
        $data['paid_lectures_count'] = $lectures->where('type',PaymentStatusEnum::PAID->value)->count();
        $data['free_lectures_count'] = $lectures->where('type',PaymentStatusEnum::FREE->value)->count();
        $data['recently_lectures'] = $lectures->where('created_at','>=' , Carbon::today())->loadMissing('therapist:id,name');
        $data['upcoming'] = $lectures->where('type',LecturesTypeEnum::LIVE->value)->where('publish_date','>=' , Carbon::today())->loadMissing('therapist:id,name');
        return $data;
    }
}
