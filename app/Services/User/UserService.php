<?php

namespace App\Services\User;

use App\Exceptions\User\InvalidUserCredentialsException;
use App\Models\User;
use App\Services\User\Data\LoginData;
use App\Services\User\Data\RegisterUserData;
use App\Services\User\Data\UpdateUserData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function store(RegisterUserData $data): User
    {
        return User::query()->create($data->toArray());
    }

    /**
     * @return array{token: string}
     *
     * @throws \App\Exceptions\User\InvalidUserCredentialsException
     */
    public function login(LoginData $data): array
    {
        if (! Auth::guard('web')->attempt($data->toArray())) {
            throw new InvalidUserCredentialsException('Invalid user credentials');
        }

        $token = Auth::guard('web')->user()->createToken('api_login');

        return [
            'token' => $token->plainTextToken,
        ];
    }

    public function updateAvatar(UploadedFile $avatar): User
    {
        /** @var \App\Models\User */
        return tap(Auth::user())->update(['avatar' => uploadImage($avatar)]);
    }

    public function update(UpdateUserData $data): User
    {
        /** @var \App\Models\User */
        $user = tap(Auth::user())->update($data->toArray());

        return $user;
    }

    public function posts(User $user, int $limit = 10, int $offset = 0): Collection
    {
        return $user
            ->posts()
            ->limit($limit)
            ->offset($offset)
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function totalPosts(User $user): int
    {
        return $user
            ->posts()
            ->count();
    }
}
