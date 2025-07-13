<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap = null;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var \App\Models\User $this */

        return [
            'id' => $this->id,
            'name' => $this->name,
            'login' => $this->login,
            'email' => $this->email,
            'subscribers' => $this->subscribtionsCount(),
            'publications' => $this->postsCount(),
            'avatar' => $this->avatar,
            'about' => $this->about,
            'isVerified' => $this->is_verified,
            'registeredAt' => $this->created_at->format('d/m/Y H:i'),
            'isSubscribed' => $this->isSubscribed(),
        ];
    }
}
