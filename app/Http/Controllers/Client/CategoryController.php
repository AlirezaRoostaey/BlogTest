<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\BlogResource;
use App\Http\Resources\Client\CategoryResource;
use App\Models\Blog;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function allCategories(Request $request): JsonResponse
    {
        $categories = Category::with(['childrenRecursive'])
            ->get();

        return $this->success(CategoryResource::collection($categories), 'all categories');
    }

    public function show($id): JsonResponse
    {
        $category = Category::with('childrenRecursive')->find($id);

        return $category ? $this->success(new CategoryResource($category)) : $this->error([], 'Not Found', 404);
    }
}
