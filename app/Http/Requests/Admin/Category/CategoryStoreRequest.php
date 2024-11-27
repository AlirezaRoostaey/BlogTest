<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:256'],
            'description' => ['required', 'string', 'max:2048'],
            'parent_id' => ['nullable', 'exists:categories,id'],
        ];
    }
}
