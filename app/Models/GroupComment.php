<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
