<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Report extends BaseModel
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


