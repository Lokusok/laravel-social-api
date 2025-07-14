<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UpdatePostTest extends TestCase
{
    use RefreshDatabase;

    private Post $post;

    protected function setUp(): void
    {
        parent::setUp();

        $this->post = Post::factory()->create([
            'user_id' => $this->getUser()->id,
        ]);
    }

    public function test_update_post(): void
    {
        $data = [
            'description' => fake()->sentence(),
        ];

        $response = $this->patch(route('posts.update', [
            'post' => $this->post->id,
        ]), $data);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'id',
            'photo',
            'user',
            'description',
            'likes',
            'isLiked',
            'comments' => [
                'total',
                'list',
            ],
            'createdAt',
        ]);

        $this->assertDatabaseHas(Post::class, [
            'id' => $this->post->id,
            'description' => $data['description'],
        ]);
    }
}
