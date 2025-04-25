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
    // Eager load borrower, item, individualItems relationships, along with their return dates
    $borrowedItems = BorrowedItem::with('borrower', 'item', 'individualItems', 'individualItemReturns')  
        ->whereIn('status', ['Borrowed', 'Returned'])  // Show items with Borrowed or Returned status
        ->orderBy('created_at', 'desc')  // Sort by the creation date in descending order (newest first)
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
        $returnDates = $request->input('return_dates'); // This should be an array of return dates (optional for partial returns)
        
        if (!is_array($scannedQRCodes)) {
            return response()->json(['message' => 'Invalid or missing QR codes.'], 400);
        }
        
        $returnedItems = [];
        $totalItemsToReturn = $borrowedItem->quantity_borrowed; // Total items originally borrowed
        
        foreach ($scannedQRCodes as $index => $scannedQRCode) {
            // Find the individual item that matches the scanned QR code
            $individualItem = $borrowedItem->individualItems()->where('qr_code', $scannedQRCode)->first();
        
            if ($individualItem) {
                // Mark the individual item as 'Available'
                $individualItem->status = 'Available';
                $individualItem->save();
        
                // Insert a record into the individual_item_returns table for this return
                \App\Models\IndividualItemReturn::create([
                    'individual_item_id' => $individualItem->id,
                    'borrowed_item_id' => $borrowedItem->id,
                    'return_date' => $returnDates[$index] ?? now(), // Use provided date or current date if not given
                ]);
                
        
                // Add to the returned items list
                $returnedItems[] = $individualItem;
            } else {
                // If an invalid QR code is found, return an error
                return response()->json(['message' => "Invalid QR code: $scannedQRCode."], 400);
            }
        }
        
        // Check if all individual items are now available
        $unreturnedItemsCount = $borrowedItem->individualItems()->where('status', '!=', 'Available')->count();
        
        if ($unreturnedItemsCount == 0) {
            // If all items are marked as Available, update the borrowed item's status to 'Returned'
            $borrowedItem->status = 'Returned';
            $borrowedItem->return_date = now(); // Set the return date for the whole borrowing record when all items are returned
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
