<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualItem extends Model
{
    use HasFactory;

    // Define which attributes are mass assignable
    protected $fillable = ['item_id', 'qr_code', 'status', 'is_archived'];

    // Define relationship with Item table
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
