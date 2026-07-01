<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class InvoiceItem extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'item_type',
        'ref_id',
        'description',
        'qty',
        'rate',
        'subtotal',
    ];

    protected $casts = [
        'qty' => 'integer',
        'rate' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'ref_id');
    }
}


