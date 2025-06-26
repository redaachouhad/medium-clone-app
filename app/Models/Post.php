<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model implements HasMedia
{

    use InteractsWithMedia;
    //
    use HasFactory;
    use HasSlug;


    protected $fillable = [
        // 'image',
        'slug',
        'title',
        'content',
        'category_id',
        'user_id',
        'published_at'
    ];


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function readTime($wordsPerMinute = 100)
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / $wordsPerMinute);
        return max(1, $minutes);
    }

    public function claps()
    {
        return $this->hasMany(Claps::class);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->width(400)
            ->nonQueued();

        $this
            ->addMediaConversion('large')
            ->width(1200)
            ->nonQueued();
    }

    public function imageUrl($nameConversion = ''): string
    {
        return $this->getFirstMedia() ? $this->getFirstMedia()->getUrl($nameConversion) : asset('no-image.jpg');
    }
}
