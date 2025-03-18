<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipment'; // Specify the table name if it's not plural
    protected $fillable = ['item_name', 'category', 'quantity', 'unit', 'description', 'arrival_date', 'status', 'storage_location'];
}
