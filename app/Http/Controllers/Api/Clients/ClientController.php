<?php

namespace App\Http\Controllers\Api\Clients;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Http\Requests\Users\ClientRequest;
use App\DataTransferObjects\Client\ClientDTO;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Client\ClientUpdateRequest;

class ClientController extends Controller
{
     public function __construct(protected UserService $clientService)
    {
    }

  public function getProfileDetails()
    {
        try {
            $client = auth()->user();
            return apiResponse(data: ClientResource::make( $client), message: trans('app.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 500);
        }
    }
    public function updateProfileData(ClientUpdateRequest $request)
{
    try {
        $clientDTO = ClientDTO::fromRequest($request);
        $client = auth()->user();
        $this->clientService->updateClient($client->id, $clientDTO); 
        return apiResponse(message: __('app.general.success_operation'));
    } catch (ValidationException $exception) {
        $mappedErrors = transformValidationErrors($exception->errors());
        return apiResponse(data: ['message' => __('app.general.invalid_inputs'), 'errors' => $mappedErrors], code: 422);
    } catch (\Exception $exception) {
        return apiResponse(message: $exception->getMessage(), code: 500);
    }
}



}
