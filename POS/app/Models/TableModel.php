<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableModel extends Model
{
    use HasFactory;

    protected $table = 'tables';
    protected $fillable = [
        'table_number',
        'availability',
        'table_status',
        'reservation_starttime',
        'reservation_endtime',
        'max_pax',
        'min_pax',
    ];
}
