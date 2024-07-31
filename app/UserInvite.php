<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserInvite extends Model
{
    public function sender(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function url()
    {
        return url("/i/invite/code/{$this->key}/{$this->token}");
    }
}
