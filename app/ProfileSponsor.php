<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileSponsor extends Model
{
    public $fillable = ['profile_id'];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
