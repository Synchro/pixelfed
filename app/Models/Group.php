<?php

namespace App\Models;

use App\HasSnowflakePrimary;
use App\Profile;
use App\Services\GroupService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, HasSnowflakePrimary, SoftDeletes;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $casts = [
        'metadata' => 'json',
    ];

    public function url()
    {
        return url("/groups/{$this->id}");
    }

    public function permalink($suffix = null)
    {
        if (! $this->local) {
            return $this->remote_url;
        }

        return $this->url().$suffix;
    }

    public function members(): HasMany
    {
        return $this->hasMany(GroupMember::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function isMember($id = false)
    {
        $id = $id ?? request()->user()->profile_id;

        // return $this->members()->whereProfileId($id)->whereJoinRequest(false)->exists();
        return GroupService::isMember($this->id, $id);
    }

    public function getMembershipType()
    {
        return $this->is_private ? 'private' : ($this->is_local ? 'local' : 'all');
    }

    public function selfRole($id = false)
    {
        $id = $id ?? request()->user()->profile_id;

        return optional($this->members()->whereProfileId($id)->first())->role ?? null;
    }
}
