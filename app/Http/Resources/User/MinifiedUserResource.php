<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MinifiedUserResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var \App\Models\User $this */

        return [
            'id' => $this->id,
            'name' => $this->name,
            'avatar' => $this->avatar,
        ];
    }
}
