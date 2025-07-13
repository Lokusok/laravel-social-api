<?php

namespace App\Http\Controllers\Api;

use App\Facades\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateAvatarRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\CurrentUserResource;
use Illuminate\Support\Facades\Auth;

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
}
