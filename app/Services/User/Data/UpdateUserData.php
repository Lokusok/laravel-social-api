<?php

namespace App\Services\User\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UpdateUserData extends Data
{
    public function __construct(
        public string|Optional $name,
        public string|Optional $login,
        public string|Optional $email,
        public string|Optional $about,
        public string|Optional $password,
    ) {}
}
