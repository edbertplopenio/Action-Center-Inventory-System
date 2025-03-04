<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    // Display the form to create a new item
    public function create()
    {
        return view('item-form'); // This view will display the item creation form
    }

    // Store the newly created item in the database
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'unit' => 'required|string|max:100',
            'description' => 'required|string',
            'storage_location' => 'required|string|max:255',
            'arrival_date' => 'required|date',
            'date_purchased' => 'required|date',
            'status' => 'required|string|max:100',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
        ]);

        // Handle image upload if an image is included
        if ($request->hasFile('image_url')) {
            // Save the image to the public storage directory
            $imagePath = $request->file('image_url')->store('images', 'public');
        } else {
            $imagePath = null; // No image uploaded, set image path to null
        }

        // Store the item in the database
        Item::create([
            'name' => $request->name,
            'category' => $request->category,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'description' => $request->description,
            'storage_location' => $request->storage_location,
            'arrival_date' => $request->arrival_date,
            'date_purchased' => $request->date_purchased,
            'status' => $request->status,
            'image_url' => $imagePath,
        ]);

        // Redirect back to the form or a different route with a success message
        return redirect()->route('inventory')->with('success', 'Item added successfully!');
    }

    // Display a list of items without pagination
    public function index()
    {
        // Retrieve all items by category without pagination
        $items = Item::where('category', 'DRRM Equipment')->get();
        $officeSupplies = Item::where('category', 'Office Supplies')->get();
        $emergencyKits = Item::where('category', 'Emergency Kits')->get();

        // Return the inventory page with all items for each category
        return view('inven', compact('items', 'officeSupplies', 'emergencyKits'));
    }
}
