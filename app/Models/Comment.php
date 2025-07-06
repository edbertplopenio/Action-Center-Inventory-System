<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Specify the fillable attributes
    protected $fillable = ['item_id', 'comment'];

    public function item()
    {
        return $this->belongsTo(Item::class); // Each comment belongs to an item
    }
}

