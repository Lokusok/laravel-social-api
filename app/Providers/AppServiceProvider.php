<?php

namespace App\Providers;

use App\Services\Post\PostService;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserService::class, UserService::class);
        $this->app->bind(PostService::class, PostService::class);
    }

    public function boot(): void
    {
        //
    }
}
