<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
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

    public function show($slug): JsonResponse
    {
        $blog = Blog::
            where('slug', $slug)
            ->where('publish_at', '<=' , Carbon::now())
            ->first();

        return $blog ? $this->success($blog) : $this->error([], 'Not Found', 404);
    }
}
