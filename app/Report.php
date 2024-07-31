<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'admin_seen' => 'datetime',
        ];
    }

    public function url()
    {
        return url('/i/admin/reports/show/'.$this->id);
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function reported()
    {
        $class = $this->object_type;

        switch ($class) {
            case \App\Status::class:
                $column = 'id';
                break;

            default:
                $class = \App\Status::class;
                $column = 'id';
                break;
        }

        return (new $class())->where($column, $this->object_id)->first();
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'object_id');
    }

    public function reportedUser(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'reported_profile_id', 'id');
    }
}
