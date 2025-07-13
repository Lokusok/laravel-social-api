<?php

namespace App\Http\Controllers\Api;

use App\Facades\Post;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post as PostModel;
use Illuminate\Routing\Controller;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('post.access')
            ->only('destroy')
        ;
    }

    public function index()
    {
        //
    }

    public function update(PostModel $post, UpdatePostRequest $request)
    {
        return PostResource::make(Post::update($post, $request->toData()));
    }

    public function store(StorePostRequest $request): PostResource
    {
        return PostResource::make(Post::store($request->toData()));
    }

    public function show(PostModel $post): PostResource
    {
        return PostResource::make($post);
    }

    public function destroy(PostModel $post)
    {
        $post->delete();

        return response()->noContent();
    }
}
