<?php

namespace App\Http\Requests\Admin\Blog;

use Illuminate\Foundation\Http\FormRequest;

class BlogUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:256'],
            'slug' => ['nullable', 'string', 'max:256'],
            'content' => ['nullable'],
            'publish_at' => ['nullable', 'date'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'status' => ['required', 'in:draft,approved'],
        ];
    }
}
