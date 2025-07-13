<?php

namespace App\Http\Requests\Post;

use App\Services\Post\Data\AddCommentData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddCommentRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'comment' => ['required', 'max:255'],
        ];
    }

    public function toData(): AddCommentData
    {
        return AddCommentData::from([
            'comment' => $this->input('comment'),
            'user_id' => Auth::id(),
        ]);
    }
}
