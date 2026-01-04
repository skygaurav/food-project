<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

/**
 * Controller for managing categories in admin panel.
 *
 * Provides CRUD operations for food categories.
 *
 * @package App\Http\Controllers\Admin
 */
class CategoryController extends Controller
{
    /**
     * List all categories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => Category::query()->orderBy('name')->get()]);
    }

    /**
     * Create a new category.
     *
     * @param  \App\Http\Requests\Admin\StoreCategoryRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = Category::query()->create($request->validated());

        return response()->json($category, 201);
    }

    /**
     * Update an existing category.
     *
     * @param  \App\Http\Requests\Admin\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $category->update($request->validated());

        return response()->json($category);
    }

    /**
     * Delete a category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json(null, 204);
    }
}
