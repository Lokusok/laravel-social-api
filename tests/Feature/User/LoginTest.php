<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory(1)->create()->first();
    }

    public function test_success_auth_with_email(): void
    {
        $response = $this->post(route('user.login'), [
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure(['token']);
    }

    public function test_success_auth_with_login(): void
    {
        $response = $this->post(route('user.login'), [
            'login' => $this->user->login,
            'password' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure(['token']);
    }
}
