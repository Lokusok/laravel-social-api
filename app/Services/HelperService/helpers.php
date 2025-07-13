<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

function responseFailed(?string $message = null, int $code = Response::HTTP_BAD_REQUEST): JsonResponse
{
    return response()->json([
        'message' => __($message) ?? __('Bad request'),
    ], $code);
}

function getModelNotFoundMessage(string $model): string
{
    return match($model) {
        'App\Models\User' => __('User not found'),
        default => __('Entity not found'),
    };
}

function uploadImage(UploadedFile $image): string
{
    $path = $image->store('avatars', 'public');

    $url = Storage::disk('public')->url($path);

    return $url;
}
