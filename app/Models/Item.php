<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes; // ✅ Added SoftDeletes trait

    // Define the fields that are mass assignable
    protected $fillable = [
        'name', 'category', 'quantity', 'unit', 'description', 
        'storage_location', 'arrival_date', 'date_purchased', 
        'status', 'image_url'
    ];

    // Enable soft delete timestamp
    protected $dates = ['deleted_at'];
}
