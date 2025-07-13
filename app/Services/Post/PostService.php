<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Services\Post\Data\StorePostData;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function store(StorePostData $data): Post
    {
        return Auth::user()->posts()->create([
            'photo' => uploadImage($data->photo),
            'description' => $data->description,
        ]);
    }
}
