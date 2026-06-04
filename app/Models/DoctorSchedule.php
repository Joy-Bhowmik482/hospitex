<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class DoctorSchedule extends BaseModel
{
    use HasFactory;

    protected $table = 'doctor_schedules';

    protected $fillable = [
        'doctor_id', 'staff_id', 'day_of_week', 'start_time', 'end_time', 'room_no', 'task_description', 'is_active',
    ];

    protected $casts = [
        'day_of_week' => 'integer',
        'staff_id' => 'integer',
        'is_active' => 'boolean',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}


