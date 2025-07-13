<?php

namespace App\Http\Controllers\Api;

use App\Facades\User;
use App\Models\User as UserModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\GetPostsRequest;
use App\Http\Requests\User\UpdateAvatarRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\Post\FeedPostResource;
use App\Http\Resources\User\CurrentUserResource;
use App\Http\Resources\User\SubscriberResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function user(): CurrentUserResource
    {
        return CurrentUserResource::make(Auth::user());
    }

    public function avatar(UpdateAvatarRequest $request): CurrentUserResource
    {
        return CurrentUserResource::make(User::updateAvatar($request->avatar()));
    }

    public function update(UpdateUserRequest $request)
    {
        return CurrentUserResource::make(User::update($request->toData()));
    }

    public function getUser(UserModel $user)
    {
        return UserResource::make($user);
    }

    public function subscribers(UserModel $user)
    {
        return SubscriberResource::collection($user->subscriptions)->resolve();
    }

    public function subscribe(UserModel $user): JsonResponse
    {
        return response()->json([
            'state' => $user->subscribe(),
        ], Response::HTTP_OK);
    }

    public function posts(UserModel $user, GetPostsRequest $request)
    {
        return response()->json([
            'posts' => FeedPostResource::collection(
                User::posts($user, $request->limit(), $request->offset())
            ),
            'total' => User::totalPosts($user),
        ]);
    }
}
