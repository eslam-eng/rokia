<?php

namespace App\Services;

use App\DataTransferObjects\Therapist\CreateTherapistDTO;
use App\DataTransferObjects\Wishlist\WishListDTO;
use App\Enums\AttachmentsType;
use App\Exceptions\GeneralException;
use App\Exceptions\NotFoundException;
use App\Filters\WishlistFilter;
use App\Models\Wishlist;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class WishlistService extends BaseService
{

    public function __construct(protected Wishlist $model)
    {

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function paginateLectures(array $filters = [], array $withRelations = []): Paginator
    {
        return $this->getQuery(filters: $filters)->with($withRelations)->simplePaginate();
    }

    public function getQuery(?array $filters = []): ?Builder
    {
        return parent::getQuery($filters)
            ->when(!empty($filters), fn(Builder $builder) => $builder->filter(new WishlistFilter($filters)));
    }

    /**
     * @param CreateTherapistDTO $therapistDTO
     * @return Builder|Model|null
     */
    public function updateOrCreate(WishListDTO $wishListDTO): Model|Builder|null
    {
        $wishListDTO->validate();
        $wishlistData = $wishListDTO->toArray();
        return $this->getQuery()->updateOrCreate($wishlistData);
    }


    /**
     * @throws NotFoundException
     * @throws GeneralException
     */
    public function destroy($id): ?bool
    {
        $wishlist = $this->findById($id);
        return $wishlist->delete();
    }
}
