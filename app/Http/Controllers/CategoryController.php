<?php

namespace App\Http\Controllers;

use App\DataTables\Category\CategoryDataTable;
use App\DataTransferObjects\category\CategoryDTO;
use App\Http\Requests\Category\CategoryRequest;
use App\Models\Category;
use App\Services\Category\CategoryService;
use Illuminate\Http\Request;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    public function __construct(public CategoryService $categoryService)
    {
    }


    public function index(CategoryDataTable $categoryDataTable, Request $request)
    {
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });

        return $categoryDataTable->with(['filters' => $filters])->render('layouts.dashboard.category.index');

    }

    public function create()
    {
        return view('layouts.dashboard.category.create');

    }

    public function store(CategoryRequest $request)
    {
        try {
            $categoryDTO = CategoryDTO::fromRequest($request);
            $this->categoryService->store($categoryDTO);
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'category created successfully'];
            return redirect(route('categories.index'))->with('toast', $toast);
        } catch (\Exception $exception) {
            $toast = ['type' => 'error', 'title' => 'Success', 'message' => $exception->getMessage()];
            return back()->with('toast', $toast);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Category $category)
    {
        return view('layouts.dashboard.category.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $categoryDTO = CategoryDTO::fromRequest($request);
            $this->categoryService->update($categoryDTO, $category);
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'category created successfully'];
            return redirect(route('categories.index'))->with('toast', $toast);
        } catch (\Exception $exception) {
            $toast = ['type' => 'error', 'title' => 'Success', 'message' => $exception->getMessage()];
            return back()->with('toast', $toast);
        }
    }


    public function destroy(Category $category)
    {
        try {
            $this->categoryService->destroy($category);
            return apiResponse(message: 'deleted successfully');
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    public function status($id)
    {
        try {
            $this->categoryService->changeStatus(id: $id);
            return apiResponse(message: __('app.categories.status_changed_successfully'));
        } catch (NotFoundHttpException $exception) {
            return apiResponse(message: __('app.categories.category_not_found'), code: 404);
        } catch (Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }
}
