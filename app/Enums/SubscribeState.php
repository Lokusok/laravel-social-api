<?php

namespace App\Enums;

enum SubscribeState: string
{
    case SUBSCRIBED = 'subscribed';
    case UNSUBSCRIBED = 'unsubscribed';
}
