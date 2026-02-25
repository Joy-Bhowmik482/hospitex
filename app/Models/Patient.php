<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'city',
        'state',
        'postal_code',
        'blood_type',
        'allergies',
        'medical_conditions',
        'emergency_contact_name',
        'emergency_contact_phone',
        'insurance_provider',
        'insurance_id',
        'date_admitted',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'date_admitted' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
