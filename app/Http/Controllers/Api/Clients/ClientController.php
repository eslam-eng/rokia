<?php

namespace App\Http\Controllers\Api\Clients;

use App\DataTransferObjects\Client\ClientDTO;
use App\DataTransferObjects\Client\UpdateClientDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ClientUpdateRequest;
use App\Http\Resources\ClientResource;
use App\Services\UserService;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    public function __construct(protected UserService $clientService)
    {
    }

    public function getProfileDetails()
    {
        try {
            $client = auth()->user();
            return apiResponse(data: ClientResource::make($client), message: trans('app.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 500);
        }
    }

    public function updateProfileData(ClientUpdateRequest $request)
    {
        try {
            $clientDTO = UpdateClientDTO::fromRequest($request);
            $client = auth()->user();
            $this->clientService->updateClientData(clientId: $client->id, clientDTO:  $clientDTO);
            return apiResponse(message: __('app.general.success_operation'));
        } catch (ValidationException $exception) {
            $mappedErrors = transformValidationErrors($exception->errors());
            return apiResponse(data: ['message' => __('app.general.invalid_inputs'), 'errors' => $mappedErrors], code: 422);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }


}
