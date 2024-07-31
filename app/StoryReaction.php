<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoryReaction extends Model
{
    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }
}
