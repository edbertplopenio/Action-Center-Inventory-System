<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the items.
     */
    public function index()
    {
        // Fetch only active (non-archived) items
        $allItems = Item::where('is_archived', false)->get(); 

        // Fetch categorized items
        $drrmItems = Item::where('is_archived', false)->where('category', 'DRRM Equipment')->get();
        $officeItems = Item::where('is_archived', false)->where('category', 'Office Supplies')->get();
        $emergencyItems = Item::where('is_archived', false)->where('category', 'Emergency Kits')->get();
        $otherItems = Item::where('is_archived', false)->where('category', 'Other Items')->get();

        // Fetch only archived items (is_archived = true)
        $archivedItems = Item::where('is_archived', true)->get();

        // Pass all variables to the view
        return view('inventory', compact('allItems', 'drrmItems', 'officeItems', 'emergencyItems', 'otherItems', 'archivedItems'));
    }

    /**
     * Store a newly created item in the database.
     */
    public function store(Request $request)
    {
        // Validate input fields
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'storage_location' => 'required|string|max:255',
            'arrival_date' => 'required|date',
            'date_purchased' => 'required|date',
            'status' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Check if the item already exists (same name & category)
        $item = Item::where('name', $request->name)
                    ->where('category', $request->category)
                    ->first();

        if ($item) {
            // If item exists, update quantity and dates
            $item->quantity += $request->quantity; 
            $item->arrival_date = $request->arrival_date; 
            $item->date_purchased = $request->date_purchased;
            $item->save();
        } else {
            // Create new item
            $item = new Item();
            $item->name = $request->name;
            $item->quantity = $request->quantity;
            $item->unit = $request->unit;
            $item->category = $request->category;
            $item->description = $request->description;
            $item->storage_location = $request->storage_location;
            $item->arrival_date = $request->arrival_date;
            $item->date_purchased = $request->date_purchased;
            $item->status = $request->status;

            // Handle image upload if provided
            if ($request->hasFile('image')) {
                $filename = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $filename);
                $item->image = 'images/' . $filename;
            }

            $item->save();
        }

        return redirect()->back()->with('success', 'Item added successfully!');
    }

    /**
     * Fetch and return item details for editing.
     */
    public function editItem($id)
    {
        $item = Item::find($id);
        if ($item) {
            return response()->json($item);
        }
        return response()->json(['error' => 'Item not found.'], 404);
    }

    /**
     * Update the specified item in the database.
     */
    public function update(Request $request, $id)
    {
        $item = Item::find($id);

        if (!$item) {
            return redirect()->back()->with('error', 'Item not found.');
        }

        // Only update editable fields
        $item->quantity = $request->quantity;
        $item->storage_location = $request->storage_location;
        $item->arrival_date = $request->arrival_date;
        $item->date_purchased = $request->date_purchased;
        $item->status = $request->status;

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $filename);
            $item->image = 'images/' . $filename;
        }

        $item->save();

        return redirect()->back()->with('success', 'Item updated successfully!');
    }

    /**
     * Archive (soft delete) an item.
     */
    public function archiveItem($id)
    {
        $item = Item::find($id);
        if ($item) {
            $item->is_archived = true; // Set is_archived to true for archiving
            $item->save(); // Save the change to the database
            return redirect()->back()->with('success', 'Item archived successfully.'); // Redirect back to the same page with success message
        }
        return redirect()->back()->with('error', 'Item not found.'); // Return an error if item not found
    }

    /**
     * Restore an archived item.
     */
    public function restoreItem($id)
    {
        $item = Item::find($id);
        if ($item) {
            $item->is_archived = false; // Set is_archived to false for restoring
            $item->save(); // Save the change to the database
            return redirect()->back()->with('success', 'Item restored successfully.'); // Redirect back to the same page with success message
        }
        return redirect()->back()->with('error', 'Item not found.'); // Return an error if item not found
    }

    /**
     * Permanently delete an archived item.
     */
    public function deletePermanently($id)
    {
        $item = Item::find($id);
        if ($item) {
            $item->delete(); // Permanently delete the item from the database
            return response()->json(['success' => true, 'message' => 'Item permanently deleted.']);
        }
        return response()->json(['success' => false, 'message' => 'Item not found.'], 404);
    }
}
