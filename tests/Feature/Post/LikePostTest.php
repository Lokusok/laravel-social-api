<?php

namespace Tests\Feature\Post;

use App\Enums\LikeState;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LikePostTest extends TestCase
{
    use RefreshDatabase;

    private Post $likedPost;

    private Post $unlikedPost;

    protected function setUp(): void
    {
        parent::setUp();

        $this->likedPost = Post::factory()->create();
        $this->likedPost->likes()->create([
            'user_id' => $this->getUser()->id,
        ]);

        $this->unlikedPost = Post::factory()->create();
    }

    public function test_like_action_to_unliked_post(): void
    {
        $response = $this->post(route('posts.like', [
            'post' => $this->unlikedPost,
        ]));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure(['state']);

        $this->assertEquals(LikeState::LIKED->value, $response->json('state'));
    }

    public function test_like_action_to_liked_post(): void
    {
        $response = $this->post(route('posts.like', [
            'post' => $this->likedPost,
        ]));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure(['state']);

        $this->assertEquals(LikeState::UNLIKED->value, $response->json('state'));
    }
}
