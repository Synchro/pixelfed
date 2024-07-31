<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountLog extends Model
{
    protected $fillable = ['*'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
