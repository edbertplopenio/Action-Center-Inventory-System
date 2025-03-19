<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * These fields can be mass assigned when creating or updating records.
     */
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
        'is_archived', // Add is_archived to fillable attributes
    ];

    /**
     * Scope to get only active (not archived) items.
     * This can be used like: Item::active()->get();
     */
    public function scopeActive($query)
    {
        return $query->where('is_archived', false); // Check if is_archived is false
    }

    /**
     * Scope to get only archived items.
     * This can be used like: Item::archived()->get();
     */
    public function scopeArchived($query)
    {
        return $query->where('is_archived', true); // Check if is_archived is true
    }

    /**
     * Check if the item is archived.
     * Usage: $item->isArchived()
     */
    public function isArchived()
    {
        return $this->is_archived; // Return true if is_archived is true
    }

    /**
     * Restore the archived item (unarchive).
     * Usage: $item->restoreItem();
     */
    public function restoreItem()
    {
        $this->is_archived = false; // Set is_archived to false to restore
        $this->save(); // Save the changes
    }

    /**
     * Archive the item (mark as archived).
     * Usage: $item->archiveItem();
     */
    public function archiveItem()
    {
        $this->is_archived = true; // Set is_archived to true to archive
        $this->save(); // Save the changes
    }
}
