<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Auth;
use Illuminate\Database\Eloquent\Model;

class DirectMessage extends Model
{
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function url()
    {
        return config('app.url').'/account/direct/m/'.$this->status_id;
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'from_id', 'id');
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'to_id', 'id');
    }

    public function me()
    {
        return Auth::user()->profile->id === $this->from_id;
    }
}
