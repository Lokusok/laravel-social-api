<?php

namespace App\Exceptions\User;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class InvalidUserCredentialsException extends Exception
{
    public function render()
    {
        return responseFailed($this->getMessage(), Response::HTTP_UNAUTHORIZED);
    }
}
