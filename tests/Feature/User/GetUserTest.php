<?php

namespace Tests\Feature\User;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class GetUserTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        Subscription::query()->create([
            'user_id' => $this->user->id,
            'subscriber_id' => $this->getUser()->id,
        ]);
    }

    public function test_get_user(): void
    {
        $response = $this->get(route('users.get-user', ['user' => $this->user]));

        $response->assertStatus(Response::HTTP_OK);

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
            'isSubscribed',
        ]);

        $this->assertTrue($response->json('isSubscribed'));
    }

    public function test_user_not_found(): void
    {
        $response = $this->get(route('users.get-user', ['user' => 999]));

        $response->assertStatus(Response::HTTP_NOT_FOUND);

        $response->assertJsonStructure(['message']);
    }
}
