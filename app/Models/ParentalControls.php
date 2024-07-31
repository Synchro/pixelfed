<?php

namespace App\Models;

use App\Services\AccountService;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParentalControls extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'permissions' => 'array',
            'email_sent_at' => 'datetime',
            'email_verified_at' => 'datetime',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function child(): BelongsTo
    {
        return $this->belongsTo(User::class, 'child_id');
    }

    public function childAccount()
    {
        if ($u = $this->child) {
            if ($u->profile_id) {
                return AccountService::get($u->profile_id, true);
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    public function manageUrl()
    {
        return url('/settings/parental-controls/manage/'.$this->id);
    }

    public function inviteUrl()
    {
        return url('/auth/pci/'.$this->id.'/'.$this->verify_code);
    }
}
