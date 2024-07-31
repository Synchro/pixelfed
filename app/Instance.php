<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Instance extends Model
{
    protected $fillable = [
        'domain',
        'banned',
        'auto_cw',
        'unlisted',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'last_crawled_at' => 'datetime',
            'actors_last_synced_at' => 'datetime',
            'notes' => 'array',
            'nodeinfo_last_fetched' => 'datetime',
            'delivery_next_after' => 'datetime',
        ];
    }

    // To get all moderated instances, we need to search where (banned OR unlisted)
    public function scopeModerated($query): void
    {
        $query->where(function ($query) {
            $query->where('banned', true)->orWhere('unlisted', true);
        });
    }

    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class, 'domain', 'domain');
    }

    public function statuses(): HasManyThrough
    {
        return $this->hasManyThrough(
            Status::class,
            Profile::class,
            'domain',
            'profile_id',
            'domain',
            'id'
        );
    }

    public function reported(): HasManyThrough
    {
        return $this->hasManyThrough(
            Report::class,
            Profile::class,
            'domain',
            'reported_profile_id',
            'domain',
            'id'
        );
    }

    public function reports(): HasManyThrough
    {
        return $this->hasManyThrough(
            Report::class,
            Profile::class,
            'domain',
            'profile_id',
            'domain',
            'id'
        );
    }

    public function media(): HasManyThrough
    {
        return $this->hasManyThrough(
            Media::class,
            Profile::class,
            'domain',
            'profile_id',
            'domain',
            'id'
        );
    }

    public function getUrl()
    {
        return url("/i/admin/instances/show/{$this->id}");
    }
}
