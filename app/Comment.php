<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
