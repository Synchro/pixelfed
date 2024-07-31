<?php

namespace App\Models;

use App\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileAlias extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
