<?php

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

function responseFailed(?string $message = null, int $code = Response::HTTP_BAD_REQUEST): JsonResponse
{
    return response()->json([
        'message' => $message ?? __('Bad request'),
    ], $code);
}
