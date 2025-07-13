<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\User\Data\RegisterUserData;

class UserService
{
    public function store(RegisterUserData $data): User
    {
        return User::query()->create($data->toArray());
    }
}
