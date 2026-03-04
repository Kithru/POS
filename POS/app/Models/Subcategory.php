<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subcategory extends Model
{
    use Hasfactory;

    protected $table = 'subcategories';
    protected $primaryKey = 'subcategory_id';

    protected $fillable = [
        'category_id',
        'subcategory_name',
        'description',
        'added_date',
        'added_by',
        'modified_date',
        'modified_by',
        'status',
    ];

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
