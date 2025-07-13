<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_post(): void
    {
        $data = [
            'photo' => UploadedFile::fake()->image('image.png'),
            'description' => fake()->sentence(),
        ];

        $response = $this->post(route('posts.store'), $data);

        $response->assertStatus(Response::HTTP_CREATED);

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

        $response->assertJson([
            'description' => $data['description'],
            'likes' => 0,
            'isLiked' => false,
            'comments' => [
                'total' => 0,
                'list' => [],
            ],
        ]);

        $this->assertDatabaseHas(Post::class, [
            'id' => $response->json('id'),
            'photo' => $response->json('photo'),
            'description' => $response->json('description'),
        ]);
    }
}
