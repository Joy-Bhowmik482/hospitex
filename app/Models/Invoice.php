<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Models\InvoiceItem;
use App\Models\Patient;
use App\Models\Admission;
use App\Models\Appointment;
use App\Models\User;

class Invoice extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'patient_id',
        'admission_id',
        'appointment_id',
        'invoice_date',
        'status',
        'subtotal',
        'discount',
        'tax',
        'net_total',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'net_total' => 'decimal:2',
    ];

    /* =========================
        RELATIONSHIPS
    ========================= */

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ✅ THIS FIXES YOUR ERROR
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}