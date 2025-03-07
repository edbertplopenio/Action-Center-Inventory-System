<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'related_documents',
        'start_year',  // Changed from start_date
        'end_year',    // Changed from end_date
        'volume',
        'medium',
        'restriction',
        'location',
        'frequency',
        'duplication',
        'time_value',
        'utility_value',

        // Retention fields
        'active',        // numeric field
        'active_unit',   // "years" or "months"
        'storage',       // numeric field
        'storage_unit',  // "years" or "months"

        'disposition',
        'grds_item',
        'status',

        // Handling Permanent Records
        'permanent', // Added explicitly as a field
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'start_year' => 'integer',  // Changed from date to integer
        'end_year'   => 'integer',  // Changed from date to integer
        'volume'     => 'string',
        'active'     => 'integer',  
        'storage'    => 'integer',
        'permanent'  => 'boolean', // Ensure correct handling of permanent status
    ];

    /**
     * Mutator/Accessor for utility_value stored as a comma-separated string
     */
    public function setUtilityValueAttribute($value)
    {
        if (is_string($value)) {
            $value = explode(',', $value);
        }
        $this->attributes['utility_value'] = !empty($value) ? implode(',', (array) $value) : null;
    }

    public function getUtilityValueAttribute($value)
    {
        return !is_null($value) ? explode(',', $value) : [];
    }

    /**
     * Scope for active records
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for archived records
     */
    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    /**
     * Scope for permanent records
     */
    public function scopePermanent($query)
    {
        return $query->where('permanent', true);
    }

    /**
     * Format retention period, including "Permanent" handling
     */
    public function getFormattedRetentionPeriodAttribute()
    {
        if ($this->permanent) {
            return "Permanent";
        }

        $active  = $this->active  ? "{$this->active} {$this->active_unit}"    : null;
        $storage = $this->storage ? "{$this->storage} {$this->storage_unit}"  : null;

        return trim(implode(', ', array_filter([$active, $storage])));
    }
}
