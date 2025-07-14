<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class GetPostTest extends TestCase
{
    use RefreshDatabase;

    private Post $post;

    protected function setUp(): void
    {
        parent::setUp();

        $this->post = Post::factory()
            ->create(['user_id' => $this->getUser()->id]);
    }

    public function test_get_post(): void
    {
        $response = $this->get(route('posts.show', [
            'post' => $this->post,
        ]));

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
    }
}
