<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_no',
        'patient_id',
        'doctor_id',
        'department_id',
        'admitted_at',
        'discharge_at',
        'status',
        'diagnosis',
        'remarks',
        'created_by',
    ];

    protected $casts = [
        'admitted_at' => 'datetime',
        'discharge_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function bedAllocations()
    {
        return $this->hasMany(BedAllocation::class);
    }
}
