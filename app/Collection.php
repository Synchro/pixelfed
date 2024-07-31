<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasSnowflakePrimary;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public $fillable = ['profile_id', 'published_at'];

    public $dates = ['published_at'];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CollectionItem::class);
    }

    public function posts(): HasManyThrough
    {
        return $this->hasManyThrough(
            Status::class,
            CollectionItem::class,
            'collection_id',
            'id',
            'id',
            'object_id'
        );
    }

    public function url()
    {
        return url("/c/{$this->id}");
    }
}
