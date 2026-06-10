<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;

class Order extends Model
{
    protected $primaryKey = 'order_id';
    protected $guarded = [];
    public $timestamps = true;
    const CREATED_AT = 'added_date';
    const UPDATED_AT = 'modified_date';

    protected $fillable = [
        'order_code',
        'discount',
        'tax',
        'status',
        'notes',
        'total_amount',
        'final_amount',
        'order_type',
        'payment_status',
        'payment_date',
        'modified_by',
        'cod_amount',
        'cancelled_date',
        'cancelled_by',
        'cancelled_reason',
        'table_no'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'order_type' => 'integer',
        'payment_status' => 'integer',
        'total_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
    ];

    public function items(){
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    public function customer(){
        return $this->hasOne(OrderCustomer::class, 'order_id', 'order_id');
    }
    
}

