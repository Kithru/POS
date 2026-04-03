<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCustomer extends Model
{
    use HasFactory;

    protected $table = 'order_customer';
    protected $primaryKey = 'order_customer_id';
    public $timestamps = false; 
    protected $guarded = [];

    // Mass assignable fields
    protected $fillable = [
        'order_id',
        'order_code',

        // Customer Details
        'customer_first_name',
        'customer_last_name',
        'customer_email',
        'customer_phone',
        'postal_code',
        'prefecture',
        'city',
        'street_name',
        'apartment_no',

        'receiver_first_name',
        'receiver_last_name',
        'receiver_email',
        'receiver_phone',
        'receiver_postal_code',
        'receiver_prefecture',
        'receiver_city',
        'receiver_street_name',
        'receiver_apartment_no',

        // Timestamps
        'added_date',
        'modified_date',
    ];

    // Date casting
    protected $dates = [
        'added_date',
        'modified_date',
    ];

    /**
     * Relationship: Each customer info belongs to an order
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}