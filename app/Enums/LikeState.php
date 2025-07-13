<?php

namespace App\Enums;

enum LikeState: string
{
    case LIKED = 'liked';
    case UNLIKED = 'unliked';
}
