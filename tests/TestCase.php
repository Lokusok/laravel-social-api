<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['avatar' => null]);
        $this->withHeader('Accept', 'application/json');

        Sanctum::actingAs($this->user);
    }

    protected function getUser(): User
    {
        return $this->user;
    }
}
