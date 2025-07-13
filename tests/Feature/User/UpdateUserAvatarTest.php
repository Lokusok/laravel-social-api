<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Storage;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UpdateUserAvatarTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_update_avatar(): void
    {
        $file = UploadedFile::fake()->image('avatar.png');

        $response = $this->post(route('user.avatar'), [
            'avatar' => $file,
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $user = $this->getUser();

        $this->assertDatabaseHas(User::class, [
            'id' => $user->id,
        ]);
        $this->assertTrue(is_string($user->avatar));

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
    }

    public function test_update_avatar_validation_mime()
    {
        $file = UploadedFile::fake()->image('avatar.gif');

        $response = $this->post(route('user.avatar'), [
            'avatar' => $file,
        ]);

        $response->assertJsonValidationErrors(['avatar']);
    }

    public function test_update_avatar_validation_size()
    {
        $file = UploadedFile::fake()->image('avatar.png')->size(2049);

        $response = $this->post(route('user.avatar'), [
            'avatar' => $file,
        ]);

        $response->assertJsonValidationErrors(['avatar']);
    }
}
