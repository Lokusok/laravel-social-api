<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class GetPostsRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'limit' => ['required', 'int', 'min:1', 'max:100'],
            'offset' => ['required', 'int', 'min:0'],
        ];
    }

    public function limit()
    {
        return $this->input('limit');
    }

    public function offset()
    {
        return $this->input('offset');
    }
}
