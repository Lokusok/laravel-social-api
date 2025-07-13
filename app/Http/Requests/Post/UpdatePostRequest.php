<?php

namespace App\Http\Requests\Post;

use App\Services\Post\Data\UpdatePostData;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => ['nullable', 'max:255'],
        ];
    }

    public function toData(): UpdatePostData
    {
        return UpdatePostData::from($this->validated());
    }
}
