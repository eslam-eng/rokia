<?php

namespace App\Services\Category;

use App\DataTransferObjects\category\CategoryDTO;
use App\Filters\CategoriesFilter;
use App\Models\Category;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CategoryService extends BaseService
{

    public function __construct(protected Category $model)
    {

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getQuery(?array $filters = []): ?Builder
    {
        return parent::getQuery($filters)
            ->when(!empty($filters), fn(Builder $builder) => $builder->filter(new CategoriesFilter($filters)));
    }


    public function datatable(array $filters = []): Builder
    {
        return $this->getQuery(filters: $filters);
    }

    public function store(CategoryDTO $categoryDTO)
    {
        $categoryDTO->validate();
        $categoryData = $categoryDTO->toArray();
        return $this->getQuery()->create($categoryData);
    }


    public function update(CategoryDTO $categoryDTO, int|Category $category)
    {
        if (is_int($category))
            $category = $this->findById($category);
        return $category->update($categoryDTO->toArray());
    }


    public function destroy(Category|int $category): ?bool
    {
        if (is_int($category))
            $category = $this->findById($category);
        return $category->delete();
    }


    public function changeStatus($id): bool
    {
        $category = $this->findById($id);
        $category->status = !$category->status;
        return $category->save();
    }
}
