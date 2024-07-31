<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class StoryReaction extends Model
{
    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }
}
