<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'unit',
        'qty_on_hand',
        'reorder_level',
    ];

    protected $casts = [
        'qty_on_hand' => 'integer',
        'reorder_level' => 'integer',
    ];

    public function movements()
    {
        return $this->hasMany(InventoryMovement::class);
    }
}
