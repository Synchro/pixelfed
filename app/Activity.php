<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['data', 'to_id', 'from_id', 'object_type'];

    protected function casts(): array
    {
        return [
            'processed_at' => 'datetime',
        ];
    }

    public function toProfile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'to_id');
    }

    public function fromProfile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'from_id');
    }
}
