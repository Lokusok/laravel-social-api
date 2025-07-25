<?php

use App\Http\Middleware\Post\PostAccessMiddleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->statefulApi();

        $middleware->alias([
            'post.access' => PostAccessMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (NotFoundHttpException $exception) {
            $previousException = $exception->getPrevious();

            if ($previousException instanceof ModelNotFoundException) {
                return responseFailed(
                    getModelNotFoundMessage($previousException->getModel()),
                    Response::HTTP_NOT_FOUND,
                );
            }

            return responseFailed(
                __('This endpoint does not exist'),
                Response::HTTP_NOT_FOUND
            );
        });
    })->create();
