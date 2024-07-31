<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    use HasFactory;

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
