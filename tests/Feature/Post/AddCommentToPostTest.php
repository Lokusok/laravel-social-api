<?php

namespace Tests\Feature\Post;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AddCommentToPostTest extends TestCase
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

    public function test_add_comment_to_post(): void
    {
        $data = [
            'comment' => fake()->sentence(),
        ];

        $response = $this->post(route('posts.comment', [
            'post' => $this->post->id,
        ]), $data);

        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonStructure([
            'id',
            'user' => [
                'id',
                'name',
                'avatar',
            ],
            'comment',
        ]);

        $response->assertJson([
            'comment' => $data['comment'],
        ]);

        $this->assertDatabaseHas(Comment::class, [
            'id' => $response->json('id'),
            'comment' => $data['comment'],
            'user_id' => $this->getUser()->id,
        ]);
    }
}
