<?php

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
    
        // Update the borrowed item status to 'Returned'
        $borrowedItem->status = 'Returned';
        $borrowedItem->return_date = now();  // Set the return date to the current timestamp
        $borrowedItem->save();
    
        // Get all individual items associated with this borrowed item
        $individualItems = $borrowedItem->individualItems;
    
        // Update the status of each individual item to 'Available'
        foreach ($individualItems as $individualItem) {
            $individualItem->status = 'Available';
            $individualItem->save();  // Save the updated status
        }
    
        // Redirect back to the return items page with a success message
        return redirect()->route('admin.return-items.index')->with('success', 'Item(s) marked as returned!');
    }
    

    // Fetch borrowed items for a specific item ID (for QR modal)
    public function getBorrowedItemsForReturn($id)
    {
        // Fetch the borrowed items' QR codes linked to this borrowing request
        $borrowedItem = BorrowedItem::findOrFail($id);
    
        // Fetch associated individual items (QR codes) using the pivot table
        $borrowedIndividualItems = \App\Models\IndividualItem::join('borrowed_item_individual_items', 'individual_items.id', '=', 'borrowed_item_individual_items.individual_item_id')
            ->where('borrowed_item_individual_items.borrowed_item_id', $borrowedItem->id)
            ->get(['individual_items.qr_code', 'individual_items.status']);
    
        return response()->json([
            'borrowedItems' => $borrowedIndividualItems
        ]);
    }
    
}
