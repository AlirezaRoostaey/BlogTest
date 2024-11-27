<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BlogStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Blog\BlogStoreRequest;
use App\Http\Requests\Admin\Blog\BlogUpdateRequest;
use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{

    public function index(Request $request): JsonResponse
    {

        $validated = $request->only(['archived', 'status', 'user_id', 'category_id']);

        $blogs = Blog::
            with(['category', 'author'])
            ->archived($validated['archived'] ?? null)
            ->status($validated['status'] ?? null)
            ->userId($validated['user_id'] ?? null)
            ->categoryId($validated['category_id'] ?? null)
        ->get();

        return $this->success($blogs);
    }

    public function show($id): JsonResponse
    {

        $blogs = Blog::find($id);

        return $blogs ? $this->success($blogs) : $this->error([], 'not Found', 404);
    }

    public function store(BlogStoreRequest $request): JsonResponse
    {

        $validated = $request->safe()->only(['title', 'slug', 'context', 'publish_at', 'category_id', 'status']);



        $blogs = Blog::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['slug']),
            'context' => $validated['context'],
            'category_id' => $validated['category_id'],
            'publish_at' => $validated['publish_at'] ?? Carbon::now(),
            'user_id' => $request->user()->id,
            'status' => $validated['status'],
        ]);
        return $this->success($blogs, 'Blog Created Successfully');
    }

    public function update(BlogUpdateRequest $request, $id): JsonResponse
    {
        $validated = $request->safe()->only(['title', 'slug', 'context', 'publish_at', 'category_id', 'status']);

        $blog = Blog::find($id);
        if($blog){
            $blog->update($validated);

            return $this->success($blog, 'Blog Updated Successfully');
        }else{

            return $this->error([], 'blog not found');
        }

    }

    public function destroy($id): JsonResponse
    {

        $blog = Blog::find($id);

        if($blog){

            $blog->delete();
            return $this->success([], 'Blogs Deleted Successfully');
        }else{

            return $this->error([], 'Blog not found', 404);
        }
    }

    public function restore($id): JsonResponse
    {

        $blog = Blog::onlyTrashed()->find($id);

        if($blog){

            $blog->restore();
            return $this->success([], 'Blogs Deleted Successfully');
        }else{

            return $this->error([], 'Blog not found', 404);
        }
    }
}
