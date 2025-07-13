<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\CurrentUserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function user(): CurrentUserResource
    {
        return CurrentUserResource::make(Auth::user());
    }
}
