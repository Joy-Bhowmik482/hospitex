<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class InsuranceProvider extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'contact',
        'email',
        'policy_rules',
        'is_active',
    ];

    protected $casts = [
        'policy_rules' => 'array',
        'is_active' => 'boolean',
    ];
}


