<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CategoryStoreRequest;
use App\Http\Requests\Admin\Category\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{

    public function index(): JsonResponse
    {

        $categories = Category::get();
        return $this->success($categories);
    }

    public function show($id): JsonResponse
    {

        $category = Category::with('childrenRecursive')->find($id);

        return $category ? $this->success($category) : $this->error([], 'not Found', 404);
    }

    public function store(CategoryStoreRequest $request): JsonResponse
    {

        $validated = $request->safe()->only(['title', 'description', 'parent_id']);


        $category = Category::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'parent_id' => $validated['parent_id'] ?? null,
        ]);
        return $this->success($category, 'category Created Successfully');
    }

    public function update(CategoryUpdateRequest $request, $id): JsonResponse
    {
        $validated = $request->safe()->only(['title', 'description', 'parent_id']);

        $category = Category::find($id);

        if($category){

            $category->update($validated);
            return $this->success($category, 'category Updated Successfully');
        }else{

            return $this->error([], 'category not found', 404);
        }
    }

    public function destroy($id): JsonResponse
    {

        $category = Category::find($id);

        if($category){

            $category->delete();
            return $this->success([], 'category Deleted Successfully');
        }else{

            return $this->error([], 'category not found', 404);
        }
    }
}