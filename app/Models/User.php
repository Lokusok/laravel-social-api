<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\SubscribeState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'login',
        'avatar',
        'about',
        'is_verified',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'bool',
        ];
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class)->with('subscriber');
    }

    public function subscribtionsCount(): int
    {
        return $this->subscriptions->count();
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function postsCount(): int
    {
        return $this->posts->count();
    }

    public function likedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'likes', 'post_id', 'user_id');
    }

    public function commentedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'comments', 'post_id', 'user_id');
    }

    public function isSubscribed(): bool
    {
        return Subscription::query()
            ->where('user_id', '=', $this->id)
            ->where('subscriber_id', '=', Auth::id())
            ->exists()
        ;
    }

    public function subscribe(): SubscribeState
    {
        $subscription = Subscription::query()
            ->where('user_id', '=', $this->id)
            ->where('subscriber_id', '=', Auth::id())
            ->first()
        ;

        if (is_null($subscription)) {
            Subscription::query()
                ->create([
                    'user_id' => $this->id,
                    'subscriber_id' => Auth::id(),
                ])
            ;

            return SubscribeState::SUBSCRIBED;
        }

        $subscription->delete();

        return SubscribeState::UNSUBSCRIBED;
    }
}
