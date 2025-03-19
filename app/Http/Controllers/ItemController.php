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
        // Fetch all items from the database
        $allItems = Item::all(); 

        // Fetch categorized items
        $drrmItems = Item::where('category', 'DRRM Equipment')->get();
        $officeItems = Item::where('category', 'Office Supplies')->get();
        $emergencyItems = Item::where('category', 'Emergency Kits')->get();
        $otherItems = Item::where('category', 'Other Items')->get();
        // Fetch only archived items (assuming 'status' column stores this info)
        $archivedItems = Item::where('status', 'Archived')->get();

        // Pass all variables to the view
        return view('inventory', compact('allItems', 'drrmItems', 'officeItems', 'emergencyItems', 'otherItems', 'archivedItems'));

    }

    /**
     * Store a newly created item in the database.
     */
    public function store(Request $request)
{
    $request->validate([
        'item_name' => 'required|string|max:255',
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

    // Check if the item already exists
    $item = Item::where('item_name', $request->item_name)
                ->where('category', $request->category)
                ->first();

    if ($item) {
        // Update existing item
        $item->quantity += $request->quantity; // Increase quantity
        $item->arrival_date = $request->arrival_date; // Update arrival date
        $item->date_purchased = $request->date_purchased; // Update purchase date
        $item->save();
    } else {
        // Create new item
        $item = new Item();
        $item->item_name = $request->item_name;
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
            $item->image_url = 'images/' . $filename;
        }

        $item->save();
    }

    return redirect()->back()->with('success', 'Item added successfully!');
}
}
