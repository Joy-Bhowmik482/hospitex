<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class InventoryMovement extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'inventory_item_id',
        'type',
        'qty',
        'reason',
        'ref_type',
        'ref_id',
        'created_by',
    ];

    protected $casts = [
        'qty' => 'integer',
    ];

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}


