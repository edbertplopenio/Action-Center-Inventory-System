<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BorrowedItem;
use App\Models\Item; // Import the Item model
use App\Models\IndividualItem; // Add this import for IndividualItem model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryRequestController extends Controller
{
    public function index()
{
    $borrowing_requests = BorrowedItem::with(['item', 'borrower'])
        ->where('status', 'Pending')
        ->orderBy('created_at', 'asc')
        ->get();

    $grouped = $borrowing_requests->groupBy('item_id');
    foreach ($grouped as $item_id => $requests) {
        $firstRequest = true;
        foreach ($requests as $request) {
            $request->can_approve = $firstRequest;
            $firstRequest = false;
        }
    }

    $items = Item::with('individualItems')->get();
    return view('admin.inventory-requests.index', compact('borrowing_requests', 'items'));
}


public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:Pending,Borrowed,Approved,Rejected,Returned,Overdue,Lost,Damaged',
    ]);

    $borrowedItem = BorrowedItem::findOrFail($id);
    $user = Auth::user();
    $borrowedItem->request_responsible_person = $user->first_name . ' ' . $user->last_name;

    if ($request->status == 'Borrowed') {
        $qrCodes = $request->input('individual_item_qr_codes');

        if (empty($qrCodes)) {
            return response()->json([
                'success' => false,
                'message' => 'No QR codes scanned.',
            ]);
        }

        // Get individual items and update their status
        $individualItems = IndividualItem::whereIn('qr_code', $qrCodes)->get();

        if ($individualItems->count() < count($qrCodes)) {
            return response()->json([
                'success' => false,
                'message' => 'Some QR codes are invalid.',
            ]);
        }

        // Update status of each individual item
        foreach ($individualItems as $item) {
            $item->status = 'Borrowed';
            $item->save();
        }

        // Attach to borrowed item
        $borrowedItem->individualItems()->attach($individualItems->pluck('id'));

        // Update inventory quantity
        $item = $borrowedItem->item;
        $item->quantity -= $borrowedItem->quantity_borrowed;
        $item->save();
    }

    $borrowedItem->status = $request->status;
    $borrowedItem->save();

    return response()->json([
        'success' => true,
        'message' => 'Status updated successfully!',
    ]);
}




    public function getItemQRCodes($itemId)
    {
        // Fetch the item with its associated individual items (QR codes)
        $item = Item::with('individualItems')->findOrFail($itemId);

        // Fetch the total quantity borrowed for this item
        $totalQuantityRequested = BorrowedItem::where('item_id', $itemId)
            ->where('status', 'Borrowed') // You can adjust this condition based on your needs
            ->sum('quantity_borrowed'); // Sum up the quantity_borrowed for each borrowed item

        // Return the QR codes and the total quantity requested for this item
        return response()->json([
            'qr_codes' => $item->individualItems,
            'total_quantity_requested' => $totalQuantityRequested, // Add this line
        ]);
    }

    // public function updateItemStatus(Request $request)
    // {
    //     // Validate the QR code and status
    //     $request->validate([
    //         'qr_code' => 'required|string',
    //         'status' => 'required|in:Available,Borrowed,Damaged,Reserved,Retired',
    //     ]);

    //     // Find the individual item by QR code
    //     $individualItem = IndividualItem::where('qr_code', $request->qr_code)->first();

    //     // Check if the item was found
    //     if ($individualItem) {
    //         // Update the status of the item
    //         $individualItem->status = $request->status;
    //         $individualItem->save();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Item status updated successfully!'
    //         ]);
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Item not found!'
    //         ]);
    //     }
    // }


    // app/Http/Controllers/Admin/InventoryRequestController.php

    public function getPendingRequestsCount()
    {
        // Remove the cache and directly fetch the current count
        $pendingRequestsCount = BorrowedItem::where('status', 'Pending')->count();

        return response()->json(['pendingRequestsCount' => $pendingRequestsCount]);
    }
}
