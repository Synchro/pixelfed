<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileMigration extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function target(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'target_profile_id');
    }
}
