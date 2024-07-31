<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class MediaTag extends Model
{
    protected $guarded = [];

    protected $visible = [
        'status_id',
        'profile_id',
        'tagged_username',
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
