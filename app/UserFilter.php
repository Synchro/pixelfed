<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFilter extends Model
{
    protected $fillable = [
        'user_id',
        'filterable_id',
        'filterable_type',
        'filter_type',
    ];

    public function mutedUserIds($profile_id)
    {
        return $this->whereUserId($profile_id)
            ->whereFilterableType(\App\Profile::class)
            ->whereFilterType('mute')
            ->pluck('filterable_id');
    }

    public function blockedUserIds($profile_id)
    {
        return $this->whereUserId($profile_id)
            ->whereFilterableType(\App\Profile::class)
            ->whereFilterType('block')
            ->pluck('filterable_id');
    }

    public function instance(): BelongsTo
    {
        return $this->belongsTo(Instance::class, 'filterable_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'user_id');
    }
}
