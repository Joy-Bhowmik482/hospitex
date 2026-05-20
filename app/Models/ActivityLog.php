<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class ActivityLog extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'route',
        'module',
        'record_type',
        'record_id',
        'ip_address',
        'user_agent',
        'login_time',
        'logout_time',
        'status',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


