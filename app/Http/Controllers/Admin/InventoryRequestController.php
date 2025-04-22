<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BorrowedItem;
use App\Models\Item; // Import the Item model
use App\Models\IndividualItem; // Add this import for IndividualItem model
use Illuminate\Http\Request;

class InventoryRequestController extends Controller
{
    public function index()
    {
        // Fetch all borrowing requests with related item and borrower details, where the status is 'Pending'
        $borrowing_requests = BorrowedItem::with(['item', 'borrower'])
            ->where('status', 'Pending')  // Add the filter for Pending status
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch all items along with their associated individual items and their QR codes
        $items = Item::with('individualItems')->get();

        // Pass the items to the view
        return view('admin.inventory-requests.index', compact('borrowing_requests', 'items'));
    }


    public function updateStatus(Request $request, $id)
    {
        // Validate the status input
        $request->validate([
            'status' => 'required|in:Pending,Borrowed,Approved,Rejected,Returned,Overdue,Lost,Damaged',
        ]);

        // Find the borrowing request by ID
        $borrowedItem = BorrowedItem::findOrFail($id);

        // If the status is "Borrowed", we need to attach individual items to the borrowed item
        if ($request->status == 'Borrowed') {
            // Ensure that individual items (QR codes) are provided
            $qrCodes = $request->input('individual_item_ids'); // This should be an array of QR codes

            if (empty($qrCodes)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No individual items selected for borrowing.',
                ]);
            }

            // Find individual item IDs by qr_code
            $individualItemIds = IndividualItem::whereIn('qr_code', $qrCodes)->pluck('id')->toArray();

            // Check if we got valid individual item ids
            if (empty($individualItemIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid individual items found for the given QR codes.',
                ]);
            }

            // Attach the individual items to the borrowed item (insert into pivot table)
            $borrowedItem->individualItems()->attach($individualItemIds);

            // Reduce the quantity in inventory
            $item = $borrowedItem->item;  // Get the associated item for this borrowed item

            // Check if enough quantity is available before reducing
            if ($item->quantity < $borrowedItem->quantity_borrowed) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available to approve this request.',
                ]);
            }

            // Deduct the quantity from the item in the inventory
            $item->quantity -= $borrowedItem->quantity_borrowed;
            $item->save();
        }

        // Update the status of the borrowed item to 'Borrowed'
        $borrowedItem->status = 'Borrowed';  // Set the status to 'Borrowed'
        $borrowedItem->save();

        // Return a response
        return response()->json([
            'success' => true,
            'message' => 'Status updated to Borrowed successfully!',
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

    public function updateItemStatus(Request $request)
    {
        // Validate the QR code and status
        $request->validate([
            'qr_code' => 'required|string',
            'status' => 'required|in:Available,Borrowed,Damaged,Reserved,Retired',
        ]);

        // Find the individual item by QR code
        $individualItem = IndividualItem::where('qr_code', $request->qr_code)->first();

        // Check if the item was found
        if ($individualItem) {
            // Update the status of the item
            $individualItem->status = $request->status;
            $individualItem->save();

            return response()->json([
                'success' => true,
                'message' => 'Item status updated successfully!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Item not found!'
            ]);
        }
    }


    public function getPendingRequestsCount()
    {
        $pendingRequestsCount = cache()->remember('pending_requests_count', 60, function () {
            return BorrowedItem::where('status', 'Pending')->count();
        });

        return response()->json(['pendingRequestsCount' => $pendingRequestsCount]);
    }
}