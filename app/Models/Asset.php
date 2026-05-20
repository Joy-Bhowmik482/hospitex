<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Asset extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'asset_code',
        'name',
        'category',
        'purchase_date',
        'cost',
        'status',
        'location',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'cost' => 'decimal:2',
    ];
}


