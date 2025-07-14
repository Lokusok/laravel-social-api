<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Subscription;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->count(50)
            ->has(
                Post::factory()
                    ->count(3)
                    ->has(
                        Comment::factory()
                            ->count(4)
                            ->for(User::factory())
                    )
                    ->has(
                        Like::factory()
                            ->count(10)
                            ->for(User::factory())
                    )
            )->create();

        $users = User::all();

        foreach ($users as $user) {
            $randomUsers = User::query()
                ->inRandomOrder(rand(1, 30))
                ->get();

            $data = [];

            foreach ($randomUsers as $randomUser) {
                $data[] = [
                    'user_id' => $user->id,
                    'subscriber_id' => $randomUser->id,
                ];
            }

            Subscription::query()->insert($data);
        }
    }
}
