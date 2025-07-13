<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriberResource extends JsonResource
{
    public static $wrap = null;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var \App\Models\User $this */

        return [
            'id' => $this->subscriber->id,
            'name' => $this->subscriber->name,
            'email' => $this->subscriber->email,
            'login' => $this->subscriber->login,
            'avatar' => $this->subscriber->avatar,
            'isVerified' => $this->subscriber->is_verified,
            'isSubscribed' => $this->subscriber->isSubscribed(),
        ];
    }
}
