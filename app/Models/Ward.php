<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Ward extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'floor',
        'gender_policy',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}


