<?php

namespace Tests\Feature\User;

use App\Enums\SubscribeState;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SubscribeTest extends TestCase
{
    use RefreshDatabase;

    private User $unsubscribedUser;

    private User $subscribedUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->unsubscribedUser = User::factory()->create();
        $this->subscribedUser = User::factory()->create();

        Subscription::factory()->create([
            'user_id' => $this->subscribedUser->id,
            'subscriber_id' => $this->getUser()->id,
        ]);
    }

    public function test_subscribe_to_unsubscribed_user(): void
    {
        $response = $this->post(route('users.subscribe', [
            'user' => $this->unsubscribedUser,
        ]));

        $response->assertStatus(Response::HTTP_OK);

        $this->assertEquals(SubscribeState::SUBSCRIBED->value, $response->json('state'));
    }

    public function test_subscribe_to_subscribed_user(): void
    {
        $response = $this->post(route('users.subscribe', [
            'user' => $this->subscribedUser,
        ]));

        $response->assertStatus(Response::HTTP_OK);

        $this->assertEquals(SubscribeState::UNSUBSCRIBED->value, $response->json('state'));
    }
}
