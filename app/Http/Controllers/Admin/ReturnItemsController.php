<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BorrowedItem;
use Illuminate\Http\Request;

class ReturnItemsController extends Controller
{
    // Display the list of borrowed and returned items
// ReturnItemsController.php

public function index()
{
    // Eager load borrower, item, and individualItems relationships
    $borrowedItems = BorrowedItem::with('borrower', 'item', 'individualItems')  // Eager load individualItems
        ->whereIn('status', ['Borrowed', 'Returned'])  // Show items with Borrowed or Returned status
        ->get();

    return view('admin.return-items.index', compact('borrowedItems'));
}


    // Mark an item as returned
    public function markAsReturned($id, Request $request)
    {
        // Find the borrowed item by ID
        $borrowedItem = BorrowedItem::findOrFail($id);
    
        // Get the scanned QR code from the request
        $scannedQRCode = $request->input('qr_code'); // Get the scanned QR code
    
        // Find the individual item that matches the scanned QR code
        $individualItem = $borrowedItem->individualItems()->where('qr_code', $scannedQRCode)->first();
    
        if ($individualItem) {
            // Mark only the scanned individual item as 'Available'
            $individualItem->status = 'Available';
            $individualItem->save();
    
            // Update the borrowed item status to 'Returned'
            $borrowedItem->status = 'Returned';
            $borrowedItem->return_date = now();  // Set the return date to the current timestamp
            $borrowedItem->save();
    
            // Add the borrowed quantity back to the item stock
            $item = $borrowedItem->item;
            $item->quantity += 1;
            $item->save();
    
            return response()->json(['message' => 'Item marked as returned and stock updated!'], 200);
        } else {
            return response()->json(['message' => 'Invalid QR code.'], 400);
        }
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
