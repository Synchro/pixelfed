<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class DiscoverCategory extends Model
{
    protected $fillable = ['slug'];

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function url()
    {
        return url('/discover/c/'.$this->slug);
    }

    public function editUrl()
    {
        return url('/i/admin/discover/category/edit/'.$this->id);
    }

    public function thumb()
    {
        return $this->media->thumb();
    }

    public function mediaUrl()
    {
        return $this->media->url();
    }

    public function items(): HasMany
    {
        return $this->hasMany(DiscoverCategoryHashtag::class, 'discover_category_id');
    }

    public function hashtags(): HasManyThrough
    {
        return $this->hasManyThrough(
            Hashtag::class,
            DiscoverCategoryHashtag::class,
            'discover_category_id',
            'id',
            'id',
            'hashtag_id'
        );
    }

    public function posts()
    {
        return Status::select('*')
            ->join('status_hashtags', 'statuses.id', '=', 'status_hashtags.status_id')
            ->join('hashtags', 'status_hashtags.hashtag_id', '=', 'hashtags.id')
            ->join('discover_category_hashtags', 'hashtags.id', '=', 'discover_category_hashtags.hashtag_id')
            ->join('discover_categories', 'discover_category_hashtags.discover_category_id', '=', 'discover_categories.id')
            ->where('discover_categories.id', $this->id);
    }
}
