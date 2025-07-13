<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\User\MinifiedUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public static $wrap = null;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var \App\Models\Comment */

        return [
            'id' => $this->id,
            'user' => MinifiedUserResource::make($this->user),
            'comment' => $this->comment,
            'createdAt' => $this->created_at->format('d/m/Y H:i'),
        ];
    }
}
