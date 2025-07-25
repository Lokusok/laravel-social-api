<?php

namespace App\Facades;

use App\Services\User\UserService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Models\User store(\App\Services\User\Data\RegisterUserData $data)
 * @method static array login(\App\Services\User\Data\LoginData $data)
 * @method static \App\Models\User updateAvatar(\Illuminate\Http\UploadedFile $avatar)
 * @method static \App\Models\User update(\App\Services\User\Data\UpdateUserData $data)
 * @method static \Illuminate\Database\Eloquent\Collection posts(\App\Models\User $user, int $limit = 10, int $offset = 0)
 * @method static int totalPosts(\App\Models\User $user)
 *
 * @see \App\Services\User\UserService
 */
class User extends Facade
{
    protected static function getFacadeAccessor()
    {
        return UserService::class;
    }
}
