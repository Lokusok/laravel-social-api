<?php

namespace App\Http\Middleware\Post;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PostAccessMiddleware
{
    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\Post */
        $post = $request->route('post');

        if ($post->user_id !== Auth::id()) {
            return responseFailed('You have no access to this post', Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
