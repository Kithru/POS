<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    // Custom primary key
    protected $primaryKey = 'category_id';

    // Because we are NOT using created_at & updated_at
    public $timestamps = false;

    // Allow mass assignment
    protected $fillable = [
        'category_name',
        'description',
        'category_code',
        'added_date',
        'added_by',
        'modified_date',
        'modified_by'
    ];

    public function items() {
        return $this->hasMany(Item::class, 'category_id'); 
    }
}
