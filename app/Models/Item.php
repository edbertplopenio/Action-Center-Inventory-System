<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Define the table name (if it's not plural of the model name)
    protected $table = 'items';

    // Define which attributes are mass assignable
    protected $fillable = [
        'name',
        'category',
        'quantity',
        'unit',
        'description',
        'storage_location',
        'arrival_date',
        'date_purchased',
        'status',
        'image_url',
        'archived',
        'is_archived',
    ];

    // Optionally, define any hidden or guarded attributes, dates, etc.
}
