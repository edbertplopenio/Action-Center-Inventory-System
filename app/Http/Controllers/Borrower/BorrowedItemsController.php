<?php

namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use App\Models\BorrowedItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowedItemsController extends Controller
{
    public function index()
    {
        $borrowed_items = BorrowedItem::with(['item', 'borrower'])
            ->where('borrower_id', Auth::id()) // Only show the logged-in user's borrowed items
            ->orderBy('created_at', 'desc')  // Order by the created_at field in descending order
            ->get();
    
        return view('borrower.borrow-equipment.index', compact('borrowed_items'));
    }
    

    public function create()
    {
        $items = Item::where('status', 'Available')->get();
        return view('borrower.borrow-equipment.create', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity_borrowed' => 'required|integer|min:1',
            'due_date' => 'required|date|after:today',
            'responsible_person' => 'required|string|max:255',
        ]);

        // Retrieve the item
        $item = Item::findOrFail($request->item_id);

        // Check if enough quantity is available
        if ($item->quantity < $request->quantity_borrowed) {
            return redirect()->back()->withErrors(['error' => 'Not enough stock available.']);
        }

        BorrowedItem::create([
            'borrower_id' => Auth::id(),
            'item_id' => $request->item_id,
            'item_code' => $item->id, // Assuming item_code is the item ID
            'quantity_borrowed' => $request->quantity_borrowed,
            'borrow_date' => now(),
            'due_date' => $request->due_date,
            'status' => 'Pending',
            'responsible_person' => $request->responsible_person,
        ]);

        return redirect()->route('borrower.borrow-equipment.index')->with('success', 'Request submitted successfully.');
    }

    public function edit(BorrowedItem $borrowedItem)
    {
        return view('borrower.borrow-equipment.edit', compact('borrowedItem'));
    }

    public function update(Request $request, BorrowedItem $borrowedItem)
    {
        $request->validate([
            'return_date' => 'nullable|date|after_or_equal:borrow_date',
            'status' => 'required|string|in:Pending,Approved,Rejected,Borrowed,Returned,Overdue,Lost,Damaged',
        ]);

        $borrowedItem->update($request->all());

        return redirect()->route('borrower.borrow-equipment.index')->with('success', 'Borrowed item updated successfully.');
    }

    public function destroy(BorrowedItem $borrowedItem)
    {
        $borrowedItem->delete();
        return redirect()->route('borrower.borrow-equipment.index')->with('success', 'Borrowed item deleted successfully.');
    }
}