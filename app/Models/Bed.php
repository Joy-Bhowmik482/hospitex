<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Bed extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'bed_no',
        'status',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function allocations()
    {
        return $this->hasOne(BedAllocation::class);
    }
}


