<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Define the fields that are mass assignable
    protected $fillable = [
        'name', 'category', 'quantity', 'unit', 'description', 'storage_location', 'arrival_date', 'date_purchased', 'status', 'image_url'
    ];

}

