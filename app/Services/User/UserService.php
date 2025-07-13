<?php

namespace App\Services\User;

use App\Exceptions\User\InvalidUserCredentialsException;
use App\Models\User;
use App\Services\User\Data\LoginData;
use App\Services\User\Data\RegisterUserData;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function store(RegisterUserData $data): User
    {
        return User::query()->create($data->toArray());
    }

    /**
     * @throws \App\Exceptions\User\InvalidUserCredentialsException
     * @return array{token: string}
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
}
