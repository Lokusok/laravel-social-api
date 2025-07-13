<?php

namespace App\Http\Controllers\Api;

use App\Facades\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post as PostModel;

class PostController extends Controller
{
    public function index()
    {
        //
    }

    public function store(StorePostRequest $request)
    {
        return PostResource::make(Post::store($request->toData()));
    }

    public function show()
    {
        //
    }
}
