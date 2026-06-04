<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Room extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'ward_id',
        'room_no',
        'room_type',
        'daily_rate',
        'is_active',
    ];

    protected $casts = [
        'daily_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function beds()
    {
        return $this->hasMany(Bed::class);
    }
}


