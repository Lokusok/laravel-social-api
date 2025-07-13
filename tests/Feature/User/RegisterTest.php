<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_register(): void
    {
        $data = [
            "name" => fake()->name(),
            "login" => fake()->unique()->userName(),
            "email" => fake()->unique()->email(),
            "password" => "123123123",
            "password_confirmation" => "123123123"
        ];

        $response = $this->post(route('user.register'), $data);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas(User::class, [
            'id' => $response->json('id'),
            'login' => $data['login'],
            'email' => $data['email'],
        ]);

        $response->assertJsonStructure([
            'id',
            'name',
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
            'email' => $data['email'],
            'subscribers' => 0,
            'publications' => 0,
            'avatar' => null,
            'about' => null,
            'isVerified' => false,
        ]);
    }

    public function test_register_validation(): void
    {
        $response = $this->post(route('user.register'), [
            "name" => null,
            "login" => null,
            "email" => "maximgmail.com",
            "password" => "12",
            "password_confirmation" => "34"
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['name', 'login', 'email', 'password']);
    }
}
