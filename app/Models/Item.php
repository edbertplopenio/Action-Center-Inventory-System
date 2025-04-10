<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Define the table name (if it's not plural of the model name)
    protected $table = 'items';

    // Define which attributes are mass assignable
    protected $fillable = [
        'name',
        'category',
        'quantity',
        'unit',
        'description',
        'storage_location',
        'arrival_date',
        'date_purchased',
        'status',
        'image_url',
        'archived',
        'is_archived',
    ];

    // Specify timestamps (if your table uses 'created_at' and 'updated_at' fields)
    public $timestamps = true;

    // Define relationship with IndividualItem
    public function individualItems()
    {
        return $this->hasMany(IndividualItem::class);
    }

    /**
     * Update the item attributes.
     *
     * @param array $data
     * @return bool
     */
    public function updateItem(array $data)
    {
        // Validate the data before saving
        $this->validateUpdateData($data);

        // Update the item's attributes
        return $this->update($data);
    }

    /**
     * Validate the update data before updating the record.
     *
     * @param array $data
     * @return void
     */
    protected function validateUpdateData(array $data)
    {
        // You can include custom validation here before updating the item
        // Example validation: Ensure quantity is a positive number
        if (isset($data['quantity']) && $data['quantity'] < 0) {
            throw new \Exception('Quantity cannot be negative');
        }
    }
}
