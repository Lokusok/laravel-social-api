<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DeletePostTest extends TestCase
{
    use RefreshDatabase;

    private Post $post;

    private Post $someonePost;

    protected function setUp(): void
    {
        parent::setUp();

        $this->post = Post::factory()
            ->create(['user_id' => $this->getUser()->id])
        ;

        $randomUser = User::factory()->create();

        $this->someonePost = Post::factory()
            ->create(['user_id' => $randomUser->id])
        ;
    }
    public function test_delete_post(): void
    {
        $response = $this->delete(route('posts.destroy', [
            'post' => $this->post->id,
        ]));

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing(Post::class, [
            'id' => $this->post->id,
        ]);
    }

    public function test_delete_someone_post(): void
    {
        $response = $this->delete(route('posts.destroy', [
            'post' => $this->someonePost->id,
        ]));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $response->assertJsonStructure([
            'message',
        ]);

        $this->assertDatabaseHas(Post::class, [
            'id' => $this->someonePost->id,
        ]);
    }
}
