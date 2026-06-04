<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends BaseModel
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'age',
        'gender',
        'address',
        'blood_type',
        'allergies',
        'medical_conditions',
        'emergency_contact_name',
        'emergency_contact_phone',
        'date_admitted',
        'status',
        'notes',
    ];

    protected $casts = [
        'date_admitted' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'notes' => 'string',
    ];

    /**
     * Get all documents for this patient.
     */
    public function documents()
    {
        return $this->hasMany(PatientDocument::class);
    }

    /**
     * Get all visits for this patient.
     */
    public function visits()
    {
        return $this->hasMany(PatientVisit::class);
    }

    /**
     * Get all appointments for this patient.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get all admissions for this patient.
     */
    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }
}


