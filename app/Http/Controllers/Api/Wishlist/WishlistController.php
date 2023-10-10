<?php

namespace App\Http\Controllers\Api\Wishlist;

use App\DataTransferObjects\Wishlist\WishListDTO;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Wishlist\WishlistRequest;
use App\Http\Resources\WishlistResource;
use App\Services\WishlistService;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct(public WishlistService $wishlistService)
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $user_id = auth()->id();
            $filters['user_id'] = $user_id;
            $withRelations = ['relatable'];
            $wishlist = $this->wishlistService->paginateLectures($filters, $withRelations);
            return WishlistResource::collection($wishlist);
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
    public function store(WishlistRequest $request)
    {
        try {
            $wishlistDTO = WishListDTO::fromRequest($request);
            $this->wishlistService->store($wishlistDTO);
            return apiResponse(message: 'added to wishlist successfully');
        } catch (\Exception $exception) {
            return apiResponse(message: 'something went wrong', code: 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->wishlistService->destroy($id);
            return apiResponse(message: 'deleted successfully');
        } catch (GeneralException $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }
}
