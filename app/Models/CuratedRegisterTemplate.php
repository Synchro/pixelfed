<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuratedRegisterTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'content', 'is_active', 'order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
