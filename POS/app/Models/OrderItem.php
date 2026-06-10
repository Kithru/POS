<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\order;

class OrderItem extends Model
{
    protected $table = 'order_items';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'item_id',
        'price',
        'quantity',
        'subtotal'
        'final_amount',
        'KOD_status',
        'updated_at'
    ];

     protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'KOD_status' => 'integer',
        'updated_at' => 'datetime',
    ];

    // Relationship with Order
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    
}