<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectionItem extends Model
{
    use HasSnowflakePrimary;

    public $fillable = [
        'collection_id',
        'object_type',
        'object_id',
        'order',
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }
}
