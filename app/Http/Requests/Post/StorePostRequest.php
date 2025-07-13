<?php

namespace App\Http\Requests\Post;

use App\Services\Post\Data\StorePostData;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'photo' => ['required', 'image', 'max:1000'],
            'description' => ['nullable', 'max:255'],
        ];
    }

    public function toData(): StorePostData
    {
        return StorePostData::from([
            'photo' => $this->file('photo'),
            'description' => $this->input('description'),
        ]);
    }
}
