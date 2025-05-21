<?php

namespace App\Observers;

use App\Models\Item;

class ItemObserver
{
    public function updating(Item $item)
    {
        // Check if item is consumable and quantity is being updated to 0 or below
        if ($item->is_consumable && $item->isDirty('quantity')) {
            if ($item->quantity <= 0) {
                $item->status = 'Out of Stock';
            }
        }
    }
}