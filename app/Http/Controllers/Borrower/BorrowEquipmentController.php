<?php

namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use App\Models\BorrowedItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BorrowEquipmentController extends Controller
{
    // Store a new borrowed item request
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = Item::findOrFail($request->item_id);

        // Check if enough quantity is available (optional - if you don't want this check, you can remove it)
        if ($item->quantity < $request->quantity) {
            return response()->json(['error' => 'Not enough stock available.'], 400);
        }

        // Create the borrowed item record without modifying the item quantity
        $borrowedItem = BorrowedItem::create([
            'borrower_id' => Auth::id(),
            'item_id' => $item->id,
            'quantity_borrowed' => $request->quantity,
            'borrow_date' => Carbon::parse($request->borrow_date),
            'due_date' => Carbon::parse($request->due_date),
            'request_responsible_person' => null,  // Set to null if no responsible person for the request
            'return_responsible_person' => null,   // Set to null if no responsible person for the return
            'status' => 'Pending',
        ]);

        // No need to update the item's quantity

        return response()->json(['success' => 'Item successfully borrowed.'], 200);
    }


    // Get borrowed items for the logged-in user
    public function index()
    {
        $borrowedItems = BorrowedItem::where('borrower_id', Auth::id())->get();

        return view('borrower.inventory.index', compact('borrowedItems'));
    }
}
