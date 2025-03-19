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
    $validatedData = $request->validate([
        'item_name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'quantity' => 'required|integer',
        'unit' => 'required|string|max:50',
        'description' => 'nullable|string',
        'storage_location' => 'required|string|max:255',
        'arrival_date' => 'required|date',
        'date_purchased' => 'required|date',
        'status' => 'required|string|max:50',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
    ]);

    // Handle the image upload if provided
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public');
        $validatedData['image_url'] = '/storage/' . $imagePath;
    }

    // Create the item
    Item::create($validatedData);

    return redirect()->route('inventory')->with('success', 'Item added successfully!');
}
}
