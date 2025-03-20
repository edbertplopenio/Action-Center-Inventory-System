<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BorrowedItem;
use Illuminate\Http\Request;

class InventoryRequestController extends Controller
{
    public function index()
    {
        // Fetch all borrowing requests with related item and borrower details
        $borrowing_requests = BorrowedItem::with(['item', 'borrower'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.inventory-requests.index', compact('borrowing_requests'));
    }


    // app/Http/Controllers/Admin/InventoryRequestController.php
public function updateStatus(Request $request, $id)
{
    // Validate the status input
    $request->validate([
        'status' => 'required|in:Pending,Approved,Rejected,Borrowed,Returned,Overdue,Lost,Damaged',
    ]);

    // Find the borrowing request by ID
    $borrowedItem = BorrowedItem::findOrFail($id);

    // Update the status
    $borrowedItem->status = $request->status;
    $borrowedItem->save();

    // Return a response
    return response()->json([
        'success' => true,
        'message' => 'Status updated successfully!',
    ]);
}

}
