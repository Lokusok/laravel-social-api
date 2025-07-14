<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_update_user(): void
    {
        $data = [
            'name' => fake()->name(),
            'login' => fake()->unique()->userName(),
            'email' => fake()->unique()->email(),
            'about' => fake()->sentence(),
        ];

        $response = $this->patch(route('user.update'), $data);

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

        $response->assertJson([
            'name' => $data['name'],
            'login' => $data['login'],
            'email' => $data['email'],
            'about' => $data['about'],
        ]);

        $user = $this->getUser();

        $this->assertDatabaseHas(User::class, [
            'id' => $user->id,
            'name' => $data['name'],
            'login' => $data['login'],
            'email' => $data['email'],
            'about' => $data['about'],
        ]);
    }
}
