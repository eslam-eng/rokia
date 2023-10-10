<?php

namespace App\Services;

use App\DataTransferObjects\Lecture\LectureDTO;
use App\DataTransferObjects\Lecture\UpdateLectureDTO;
use App\DataTransferObjects\Therapist\TherapistDTO;
use App\DataTransferObjects\Wishlist\WishListDTO;
use App\Enums\AttachmentsType;
use App\Exceptions\GeneralException;
use App\Exceptions\NotFoundException;
use App\Filters\LecturesFilter;
use App\Models\Lecture;
use App\Models\UserLecture;
use App\Models\Wishlist;
use getID3;
use getid3_lib;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class WishlistService extends BaseService
{

    public function __construct(protected Wishlist $model)
    {

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getQuery(?array $filters = []): ?Builder
    {
        return parent::getQuery($filters)
            ->when(!empty($filters), fn(Builder $builder) => $builder->filter(new LecturesFilter($filters)));
    }

    public function paginateLectures(array $filters = [], array $withRelations = []): \Illuminate\Contracts\Pagination\Paginator
    {
        return $this->getQuery(filters: $filters)->with($withRelations)->simplePaginate();
    }

    /**
     * @param TherapistDTO $therapistDTO
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
