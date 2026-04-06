<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Report extends Model
{
    protected $fillable = [
        'name',
        'type',
        'parameters',
        'data',
        'created_by',
    ];

    protected $casts = [
        'parameters' => 'array',
        'data' => 'array',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
