<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'policy_rules',
    ];

    protected $casts = [
        'policy_rules' => 'array',
    ];
}
