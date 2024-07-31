<?php

namespace App\Models;

use App\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupComment extends Model
{
    use HasFactory;

    public $guarded = [];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function url()
    {
        return '/group/'.$this->group_id.'/c/'.$this->id;
    }
}
