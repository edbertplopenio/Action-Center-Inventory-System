<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndividualItemReturn extends Model
{
    // The table associated with the model.
    protected $table = 'individual_item_returns';

    // Fillable fields
    protected $fillable = [
        'individual_item_id',
        'borrowed_item_id',
        'return_date',
        'remarks', // Add remarks to the fillable array
    ];

    // Define the relationship with the IndividualItem model
    public function individualItem()
    {
        return $this->belongsTo(IndividualItem::class, 'individual_item_id');
    }

    // Optionally, you can add a method to format remarks or handle them before saving if needed
}
