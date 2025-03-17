<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes; // ✅ Enables soft deletes

    // Define the fields that are mass assignable
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
        'image_url'
    ];

    // Enable soft delete timestamp
    protected $dates = ['deleted_at'];

    /**
     * Scope to get only non-archived (active) items.
     */
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * Scope to get only archived items.
     */
    public function scopeArchived($query)
    {
        return $query->onlyTrashed();
    }

    /**
     * Restore an item from archive.
     */
    public function restoreItem()
    {
        return $this->restore();
    }

    /**
     * Archive an item (soft delete).
     */
    public function archiveItem()
    {
        return $this->delete();
    }
}
