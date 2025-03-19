<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'category',
        'quantity',
        'unit',
        'description',
        'storage_location',
        'arrival_date',
        'date_purchased',
        'status',
        'image',
    ];
}
