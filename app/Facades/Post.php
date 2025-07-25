<?php

namespace App\Facades;

use App\Services\Post\PostService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Models\Post store(\App\Services\Post\Data\StorePostData $data)
 * @method static \App\Models\Post update(\App\Models\Posts $post, \App\Services\Post\Data\UpdatePostData $data)
 * @method static \Illuminate\Database\Eloquent\Collection feed(int $limit = 10, int $offset = 0)
 * @method static int totalFeedPosts()
 *
 * @see \App\Services\Post\PostService
 */
class Post extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PostService::class;
    }
}
