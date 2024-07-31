<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'actor_id', 'id');
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'profile_id', 'id');
    }

    public function item(): MorphTo
    {
        return $this->morphTo();
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'item_id', 'id');
    }

    public function tag(): HasOne
    {
        return $this->hasOne(MediaTag::class, 'item_id', 'id');
    }
}
