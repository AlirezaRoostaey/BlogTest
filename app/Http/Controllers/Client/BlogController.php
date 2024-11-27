<?php

namespace App\Http\Controllers\Client;

use App\Enums\BlogStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Client\BlogResource;
use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function allBlogs(Request $request): JsonResponse
    {

        $validated = $request->only(['user_id', 'category_id']);

        $blogs = Blog::with(['category', 'author'])
            ->userId($validated['user_id'] ?? null)
            ->categoryId($validated['category_id'] ?? null)

            ->where('publish_at', '<=' , Carbon::now())
            ->where('status', BlogStatus::APPROVED)
            ->get();

        return $this->success(BlogResource::collection($blogs), 'all blogs');
    }

    public function show($slug): JsonResponse
    {
        $blog = Blog::
            where('slug', $slug)
            ->where('publish_at', '<=' , Carbon::now())
            ->first();

        return $blog ? $this->success(new BlogResource($blog)) : $this->error([], 'Not Found', 404);
    }
}
