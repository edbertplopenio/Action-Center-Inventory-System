<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'quantity',
        'unit',
        'description',
        'date_purchased',
        'arrival_date',
        'status',
        'image',
        'storage_location',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
