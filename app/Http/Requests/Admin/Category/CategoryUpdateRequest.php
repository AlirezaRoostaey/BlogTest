<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:256'],
            'description' => ['nullable', 'string', 'max:2048'],
            'parent_id' => ['nullable', 'exists:users,id'],
        ];
    }
}
