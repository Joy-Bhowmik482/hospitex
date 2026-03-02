<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientVisit extends Model
{
    use HasFactory;

    protected $table = 'patient_visits';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'visit_type',
        'visit_date',
        'chief_complaint',
        'diagnosis',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'visit_date' => 'datetime',
    ];

    /**
     * Get the patient associated with this visit.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the doctor who conducted the visit.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Get the user who created this visit record.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
