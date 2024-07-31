<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jenssegers\Agent\Agent;

class UserDevice extends Model
{
    protected $fillable = [
        'user_id',
        'ip',
        'user_agent',
    ];

    public $timestamps = [
        'last_active_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUserAgent()
    {
        if (! $this->user_agent) {
            return 'Unknown';
        }
        $agent = new Agent();
        $agent->setUserAgent($this->user_agent);

        return $agent;
    }
}
