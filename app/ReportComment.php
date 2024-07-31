<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ReportComment extends Model
{
    protected $guarded = [];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
