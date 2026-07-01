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

    /**
     * Boot the model - auto-generate code on creation
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->code)) {
                $model->code = self::generateUniqueCode();
            }
        });
    }

    /**
     * Generate a unique insurance provider code
     * Format: INS-00001, INS-00002, etc.
     */
    public static function generateUniqueCode()
    {
        $lastProvider = self::latest('id')->first();
        $nextNumber = ($lastProvider ? (int) str_replace('INS-', '', $lastProvider->code) : 0) + 1;
        return 'INS-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}


