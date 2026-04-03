<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prefecture extends Model
{
   use HasFactory;

    protected $table = 'prefectures';
    protected $primaryKey = 'prefecture_id';
    protected $fillable = [
        'prefecture_name',
        'amount',
    ];
    protected $casts = [
        'amount' => 'decimal:2',
    ];
}
