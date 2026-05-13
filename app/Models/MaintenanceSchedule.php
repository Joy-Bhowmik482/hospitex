<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'maintenance_type',
        'priority',
        'scheduled_date',
        'scheduled_end_date',
        'technician_name',
        'technician_contact',
        'department',
        'status',
        'estimated_cost',
        'actual_cost',
        'description',
        'work_performed',
        'parts_used',
        'notes',
        'completed_date',
        'created_by',
    ];

    protected $casts = [
        'scheduled_date' => 'datetime',
        'scheduled_end_date' => 'datetime',
        'completed_date' => 'datetime',
        'estimated_cost' => 'decimal:2',
        'actual_cost' => 'decimal:2',
    ];

    // Relationships
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_date', '>=', now())
                    ->where('status', '!=', 'completed');
    }

    public function scopeOverdue($query)
    {
        return $query->where('scheduled_date', '<', now())
                    ->where('status', '!=', 'completed');
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('scheduled_date', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereBetween('scheduled_date', [now()->startOfMonth(), now()->endOfMonth()]);
    }
}
