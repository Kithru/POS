<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items'; 
    protected $primaryKey = 'item_id';

    protected $fillable = [
        'item_name',
        'currency',
        'category_id',
        'subcategory_id',
        'description',
        'item_code',
        'price',
        'quantity',
        'countable',
        'image',
        'added_date',
        'added_by',
        'modified_date',
        'modified_by'
    ];

    public function category() {
        return $this->belongsTo(Category::class,'category_id','category_id');
    }

    public function subcategory() {
        return $this->belongsTo(SubCategory::class,'subcategory_id','subcategory_id');
    }

    public $timestamps = false; // since you use custom added_date/modified_date
}
