<?php

namespace App\Http\Requests\Admin\Blog;

use Illuminate\Foundation\Http\FormRequest;

class BlogStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:256'],
            'slug' => ['required', 'string', 'max:256'],
            'content' => ['required'],
            'publish_at' => ['required', 'date'],
            'category_id' => ['required', 'exists:categories,id'],
            'status' => ['required', 'in:draft,approved'],
        ];
    }
}
