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
    
        // Get the scanned QR codes from the request
        $scannedQRCodes = $request->input('qr_codes'); // This should be an array of QR codes
    
        if (!is_array($scannedQRCodes)) {
            return response()->json(['message' => 'Invalid or missing QR codes.'], 400);
        }
    
        $returnedItems = [];
        $totalItemsToReturn = $borrowedItem->quantity_borrowed; // Total items originally borrowed
    
        foreach ($scannedQRCodes as $scannedQRCode) {
            // Find the individual item that matches the scanned QR code
            $individualItem = $borrowedItem->individualItems()->where('qr_code', $scannedQRCode)->first();
    
            if ($individualItem) {
                // Mark the individual item as 'Available'
                $individualItem->status = 'Available';
                $individualItem->save();
    
                // Add to the returned items list
                $returnedItems[] = $individualItem;
            } else {
                // If an invalid QR code is found, return an error
                return response()->json(['message' => "Invalid QR code: $scannedQRCode."], 400);
            }
        }
    
        // Only update the status of the borrowed item if all items have been returned
        if (count($returnedItems) === $totalItemsToReturn) {
            $borrowedItem->status = 'Returned';
            $borrowedItem->return_date = now(); // Set the return date to the current timestamp
            $borrowedItem->save();
        }
    
        // Update the item stock
        $item = $borrowedItem->item;
        $item->quantity += count($returnedItems);
        $item->save();
    
        return response()->json(['message' => 'Items marked as returned and stock updated!', 'returnedItems' => $returnedItems], 200);
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
