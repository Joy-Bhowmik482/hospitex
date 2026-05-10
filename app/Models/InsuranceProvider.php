<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceProvider extends Model
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
