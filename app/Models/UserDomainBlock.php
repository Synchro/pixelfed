<?php

namespace App\Models;

use App\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDomainBlock extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }
}
