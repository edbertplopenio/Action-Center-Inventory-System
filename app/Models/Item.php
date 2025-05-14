<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;  // Import Carbon for date manipulation

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
        'status',
        'image_url',
        'archived',
        'is_archived',
        'added_at', // Add this field here for mass assignment
        'brand', // New field for brand
        'expiration_date', // New field for expiration date
        'date_tested_inspected', // New field for date tested/inspected
        'inventory_date', // New field for inventory date
    ];

    // Specify timestamps (if your table uses 'created_at' and 'updated_at' fields)
    public $timestamps = true;


    // Define relationship with IndividualItem (already present in your code)
    public function individualItems()
    {
        return $this->hasMany(IndividualItem::class);
    }

    /**
     * Boot method to handle auto-setting of added_at timestamp when creating an item.
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically set 'added_at' to the current time when creating a new item
        static::creating(function ($item) {
            if (!$item->added_at) {
                $item->added_at = Carbon::now();  // Set added_at to the current time if it's not provided
            }

            // Automatically set 'inventory_date' if it's not provided
            if (!$item->inventory_date) {
                $item->inventory_date = Carbon::now()->toDateString(); // Set to the current date if not provided
            }
        });
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

    /**
     * Scope to retrieve items ordered by the added_at timestamp in descending order.
     * This scope can be used when fetching items to ensure the most recent items appear first.
     *
     * @param $query
     * @return mixed
     */
    public function scopeNewestFirst($query)
    {
        return $query->orderBy('added_at', 'desc');  // Use added_at instead of created_at
    }

    /**
     * Check if the item is "new" (added within the last 5 days).
     *
     * @return bool
     */
    public function isNew()
    {
        // Calculate if the item is new by comparing 'added_at' with the current date
        return Carbon::parse($this->added_at)->diffInDays(now()) <= 5;
    }
}
