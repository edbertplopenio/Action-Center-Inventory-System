<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualItem extends Model
{
    use HasFactory;

    // Define the table name (if it's not plural of the model name)
    protected $table = 'individual_items';

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'item_id',
        'qr_code',
        'status',
        'is_archived',
    ];

    // Define the inverse relationship to the Item model
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function borrowedItems()
{
    return $this->belongsToMany(BorrowedItem::class, 'borrowed_item_individual_items', 'individual_item_id', 'borrowed_item_id');
}

}