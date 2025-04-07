<?php

// app/Http/Controllers/Admin/ReturnItemsController.php
// app/Http/Controllers/Admin/ReturnItemsController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BorrowedItem;
use Illuminate\Http\Request;

class ReturnItemsController extends Controller
{
    // Display the list of borrowed and returned items
    public function index()
    {
        // Eager load the borrower relationship along with the item details
        $borrowedItems = BorrowedItem::with('borrower', 'item')  // Eager loading both borrower and item
                                      ->whereIn('status', ['Borrowed', 'Returned'])  // Show items with Borrowed or Returned status
                                      ->get();

        return view('admin.return-items.index', compact('borrowedItems'));
    }

    // Mark an item as returned
    public function markAsReturned($id)
    {
        // Find the borrowed item by ID
        $borrowedItem = BorrowedItem::findOrFail($id);

        // Update the status to 'Returned' and set return_date to now
        $borrowedItem->status = 'Returned';
        $borrowedItem->return_date = now();  // Set the return date to the current timestamp
        $borrowedItem->save();

        return redirect()->route('admin.return-items.index')->with('success', 'Item marked as returned!');
    }
}