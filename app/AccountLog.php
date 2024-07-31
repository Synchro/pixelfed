<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class AccountLog extends Model
{
    protected $fillable = ['*'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
