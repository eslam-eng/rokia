<?php

namespace App\Http\Controllers\Api\Therapist;

use App\DataTransferObjects\Therapist\CreateTherapistDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ThereapistRequest;
use App\Http\Resources\ClientResource;
use App\Services\TherapistService;
use App\Services\UserService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TherapistController extends Controller
{
    public function __construct(protected TherapistService $therapistService, public UserService $service)
    {
    }
}
