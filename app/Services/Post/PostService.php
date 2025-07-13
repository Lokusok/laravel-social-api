<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Services\Post\Data\StorePostData;
use App\Services\Post\Data\UpdatePostData;
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

    public function update(Post $post, UpdatePostData $data): Post
    {
        $post->update($data->toArray());

        return $post;
    }
}
