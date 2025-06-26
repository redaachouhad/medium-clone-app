<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Image\Enums\CropPosition;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Manipulations;

class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, InteractsWithMedia;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        // 'image',
        'bio',
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
        ];
    }

    // revoie les posts publié par un seul utilisateur.    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // cette fonction revoie les followers qui me suivent.
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', relatedPivotKey: 'follower_id');
    }

    // cette fonction revoie les utilisateur que je suis
    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function isFollowedBy(User $user)
    {
        return $this->followers->contains($user);
    }

    public function hasClapped(Post $post)
    {
        return $post->claps()
            ->where('user_id', $this->id)
            ->where('post_id', $post->id)
            ->exists()
        ;
    }


    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('avatar')
            ->width(200)
            ->nonQueued();
    }
    public function imageUrl($nameConversion = ''): string
    {
        return $this->getFirstMedia()->getUrl($nameConversion);
    }
}
