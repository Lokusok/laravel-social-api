<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class GetCurrentUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_get_current_user(): void
    {
        $response = $this->get(route('user.current'));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'id',
            'name',
            'login',
            'email',
            'subscribers',
            'publications',
            'avatar',
            'about',
            'isVerified',
            'registeredAt',
        ]);
    }
}
