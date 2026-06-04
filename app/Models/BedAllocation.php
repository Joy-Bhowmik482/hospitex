<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class BedAllocation extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'admission_id',
        'bed_id',
        'allocated_at',
        'released_at',
        'allocation_status',
        'notes',
    ];

    protected $casts = [
        'allocated_at' => 'datetime',
        'released_at' => 'datetime',
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function bed()
    {
        return $this->belongsTo(Bed::class);
    }
}


