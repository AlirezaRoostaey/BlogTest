<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class VerifyOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'otp' => ['required', 'numeric', 'digits:5'],
            'name' => ['required', 'string', 'max:256'],
            'password' =>  ['required', 'confirmed', Password::min(8)->mixedCase()],
        ];
    }
}
