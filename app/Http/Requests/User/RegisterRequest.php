<?php

namespace App\Http\Requests\User;

use App\Services\User\Data\RegisterUserData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'login' => ['required', 'string', 'max:254', Rule::unique('users', 'login')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'confirmed'],
        ];
    }

    public function toData(): RegisterUserData
    {
        return RegisterUserData::from($this->validated());
    }
}
