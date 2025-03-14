<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowingSlip extends Model
{
    protected $fillable = [
        'name',
        'department',
        'email',
        'responsible_person',  // Add this field
        'item_code',
        'borrow_date',
        'quantity',
        'due_date',
        'signature',
    ];
}



