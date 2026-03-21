<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';

    public $timestamps = true;
    const CREATED_AT = 'added_date';
    const UPDATED_AT = 'modified_date';

    protected $fillable = [
        'order_code',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'receiver_name',
        'receiver_email',
        'receiver_phone',
        'receiver_address',
        'status',
        'notes',
        'total_amount'
    ];

    public function items() {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}

