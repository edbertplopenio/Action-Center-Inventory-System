<?php

// BorrowedItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;  // Import Carbon

class BorrowedItem extends Model
{
    use HasFactory;

    protected $table = 'borrowed_items';

    protected $fillable = [
        'borrower_id',
        'item_id',
        'item_code',
        'quantity_borrowed',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
        'responsible_person',
        'is_archived',
    ];

    // Cast borrow_date and due_date to Carbon instances
    protected $casts = [
        'borrow_date' => 'datetime',
        'due_date' => 'date', // Cast due_date as a date type
        'return_date' => 'date', // Cast return_date as a date type
    ];

    // Relationship with Item model
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // Relationship with User (Borrower)
    public function borrower()
    {
        return $this->belongsTo(User::class, 'borrower_id');
    }

    public function individualItems()
{
    return $this->belongsToMany(IndividualItem::class, 'borrowed_item_individual_items', 'borrowed_item_id', 'individual_item_id');
}

}

