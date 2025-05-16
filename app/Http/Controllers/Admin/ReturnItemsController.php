<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BorrowedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnItemsController extends Controller
{
    // Display the list of borrowed and returned items
    // ReturnItemsController.php

public function index()
{
    $borrowedItems = BorrowedItem::with('borrower', 'item', 'individualItems', 'individualItemReturns')
        ->whereIn('status', ['Borrowed', 'Returned', 'Pending Return']) // Changed to Pending Return
        ->get();

    $isSupervisor = Auth::check() && Auth::user()->user_role === 'Supervisor';

    return view('admin.return-items.index', compact('borrowedItems', 'isSupervisor'));
}



public function approveAllPending($id)
{
    $borrowedItem = BorrowedItem::findOrFail($id);

    if ($borrowedItem->status !== 'Pending Return') { // Check for Pending Return
        return response()->json(['message' => 'This item is not in pending return status.'], 400);
    }

    // Get all individual items marked as Pending Return
    $pendingItems = $borrowedItem->individualItems()->where('status', 'Pending Return')->get();

    $returnedCount = 0;

    foreach ($pendingItems as $item) {
        $item->status = 'Available';
        $item->save();

        $latestReturn = \App\Models\IndividualItemReturn::where('individual_item_id', $item->id)
            ->latest()
            ->first();

        if ($latestReturn) {
            $latestReturn->remarks = 'Good';
            $latestReturn->save();
        }

        $returnedCount++;
    }

    $mainItem = $borrowedItem->item;
    $mainItem->quantity += $returnedCount;
    $mainItem->save();

    $unreturnedCount = $borrowedItem->individualItems()
        ->where('status', '!=', 'Available')
        ->count();

    $borrowedItem->status = $unreturnedCount > 0 ? 'Borrowed' : 'Returned';
    $borrowedItem->save();

    return response()->json(['message' => 'All pending return items approved.'], 200);
}



    // Mark an item as returned
    public function markAsReturned($id, Request $request)
    {
        $borrowedItem = BorrowedItem::findOrFail($id);
        $scannedQRCodes = $request->input('qr_codes');
        $returnDates = $request->input('return_dates');
        $remarks = $request->input('remarks'); // Get remarks from the request

        if (!is_array($scannedQRCodes) || !is_array($returnDates) || !is_array($remarks)) {
            return response()->json(['message' => 'Invalid or missing QR codes, return dates, or remarks.'], 400);
        }

        $returnedItems = [];

        // Get the logged-in user's full name
        $user = Auth::user();
        $responsiblePerson = $user->first_name . ' ' . $user->last_name;  // Concatenate first and last name

        foreach ($scannedQRCodes as $index => $scannedQRCode) {
            $individualItem = $borrowedItem->individualItems()->where('qr_code', $scannedQRCode)->first();

            if ($individualItem) {
                // Mark the individual item as 'Available'
                $individualItem->status = 'Available';
                $individualItem->save();

                // Store return date and remarks in individual_item_returns
                \App\Models\IndividualItemReturn::create([
                    'individual_item_id' => $individualItem->id,
                    'borrowed_item_id' => $borrowedItem->id,
                    'return_date' => $returnDates[$index] ?? now(),
                    'remarks' => $remarks[$index] ?? 'Not Checked', // Default to 'Not Checked' if no remark
                ]);

                $returnedItems[] = $individualItem;
            } else {
                return response()->json(['message' => "Invalid QR code: $scannedQRCode."], 400);
            }
        }

        // Update the return_responsible_person in the borrowed_items table
        $borrowedItem->return_responsible_person = $responsiblePerson;
        $borrowedItem->save();

        // Check if all individual items are now available
        $unreturnedItemsCount = $borrowedItem->individualItems()->where('status', '!=', 'Available')->count();

        if ($unreturnedItemsCount == 0) {
            // If all items are marked as Available, update the borrowed item's status to 'Returned'
            $borrowedItem->status = 'Returned';
            $borrowedItem->save();
        }

        // Update the item stock
        $item = $borrowedItem->item;
        $item->quantity += count($returnedItems);
        $item->save();

        return response()->json(['message' => 'Items marked as returned and stock updated!', 'returnedItems' => $returnedItems], 200);
    }





 public function markAsPending($id, Request $request)
{
    $borrowedItem = BorrowedItem::findOrFail($id);
    $scannedQRCodes = $request->input('qr_codes');
    $returnDates = $request->input('return_dates');
    $remarks = $request->input('remarks');

    foreach ($scannedQRCodes as $index => $scannedQRCode) {
        $individualItem = $borrowedItem->individualItems()->where('qr_code', $scannedQRCode)->first();

        if ($individualItem && $individualItem->status !== 'Available') {
            $individualItem->status = 'Pending Return'; // Set to Pending Return
            $individualItem->save();

            \App\Models\IndividualItemReturn::create([
                'individual_item_id' => $individualItem->id,
                'borrowed_item_id' => $borrowedItem->id,
                'return_date' => $returnDates[$index] ?? now(),
                'remarks' => $remarks[$index] ?? 'Not Checked',
                'status' => 'Pending Return' // Set status to Pending Return
            ]);
        }
    }

    $borrowedItem->status = 'Pending Return'; // Update parent status
    $borrowedItem->save();

    return response()->json(['message' => 'Items marked as pending return!'], 200);
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

 public function rejectPending($id)
{
    $borrowedItem = BorrowedItem::findOrFail($id);

    if ($borrowedItem->status !== 'Pending Return') { // Check for Pending Return
        return response()->json(['message' => 'Item is not pending return.'], 400);
    }

    $pendingItems = $borrowedItem->individualItems()
        ->where('status', 'Pending Return')
        ->get();

    foreach ($pendingItems as $item) {
        $item->status = 'Borrowed';
        $item->save();

        $latestReturn = \App\Models\IndividualItemReturn::where('borrowed_item_id', $borrowedItem->id)
            ->where('individual_item_id', $item->id)
            ->latest()
            ->first();

        if ($latestReturn) {
            $latestReturn->delete();
        }
    }

    $unreturnedExists = $borrowedItem->individualItems()
        ->where('status', '!=', 'Available')
        ->exists();

    $borrowedItem->status = $unreturnedExists ? 'Borrowed' : 'Returned';
    $borrowedItem->save();

    return response()->json(['message' => 'Pending return items reverted.'], 200);
}
}
