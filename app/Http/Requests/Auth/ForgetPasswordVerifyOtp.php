<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ForgetPasswordVerifyOtp extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email', 'max:512'],
            'password' =>  ['required', 'confirmed', Password::min(8)->mixedCase()],
            'otp' => ['required', 'numeric', 'digits:5'],
        ];
    }
}
