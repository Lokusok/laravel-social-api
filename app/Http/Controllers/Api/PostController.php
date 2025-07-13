<?php

namespace App\Http\Controllers\Api;

use App\Facades\Post;
use App\Http\Requests\Post\AddCommentRequest;
use App\Http\Requests\Post\GetPostsRequest;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Post\FeedPostResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Post as PostModel;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('post.access')
            ->only('destroy')
        ;
    }

    public function index(GetPostsRequest $request)
    {
        $posts = FeedPostResource::collection(
            Post::feed($request->limit(), $request->offset())
        );

        return response()->json([
            'posts' => $posts,
            'total' => Post::totalFeedPosts(),
        ]);
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

    public function like(PostModel $post)
    {
        return response()->json([
            'state' => $post->like(),
        ], Response::HTTP_OK);
    }

    public function addComment(PostModel $post, AddCommentRequest $request): CommentResource
    {
        return CommentResource::make($post->comments()->create($request->toData()->toArray()));
    }
}
