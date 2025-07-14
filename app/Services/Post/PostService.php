<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Services\Post\Data\StorePostData;
use App\Services\Post\Data\UpdatePostData;
use Illuminate\Database\Eloquent\Collection;
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

    /**
     * @return Collection<\App\Models\Post>
     */
    public function feed(int $limit = 10, int $offset = 0): Collection
    {
        return Auth::user()
            ->feedPosts()
            ->limit($limit)
            ->offset($offset)
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function totalFeedPosts(): int
    {
        return Auth::user()
            ->feedPosts()
            ->count();
    }
}
