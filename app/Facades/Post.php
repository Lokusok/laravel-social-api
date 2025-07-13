<?php

namespace App\Facades;

use App\Services\Post\PostService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Models\Post store(\App\Services\Post\Data\StorePostData $data)
 * @method static \App\Models\Post update(\App\Models\Posts $post, \App\Services\Post\Data\UpdatePostData $data)
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
