<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo',
        'description',
    ];

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function totalComments(): int
    {
        return $this->comments->count();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function totalLikes(): int
    {
        return $this->likes->count();
    }

    public function isLiked(): bool
    {
        return Like::query()
            ->where('post_id', '=', $this->id)
            ->where('user_id', '=', Auth::id())
            ->exists()
        ;
    }
}
