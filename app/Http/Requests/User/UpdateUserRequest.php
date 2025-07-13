<?php

namespace App\Http\Requests\User;

use App\Services\User\Data\UpdateUserData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable'],
            'login' => ['nullable', Rule::unique('users', 'login'), 'max:255'],
            'email' => ['nullable', 'email', Rule::unique('users', 'email'), 'max:255'],
            'about' => ['nullable', 'max:255'],
            'password' => ['nullable', 'confirmed'],
        ];
    }

    public function toData(): UpdateUserData
    {
        return UpdateUserData::from($this->validated());
    }
}
