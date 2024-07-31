<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class StoryView extends Model
{
    public $fillable = ['story_id', 'profile_id'];

    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }
}
