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
            'is_archived' => false, // Set default as not archived
        ]);

        // Redirect back to the form or a different route with a success message
        return redirect()->route('inventory')->with('success', 'Item added successfully!');
    }

    // Display a list of items without pagination
    public function index()
    {
        $allItems = Item::all(); // Fetch all items
        $items = Item::where('category', 'DRRM Equipment')->get(); // Fetch only DRRM Equipment items
        $officeSupplies = Item::where('category', 'Office Supplies')->get();
        $emergencyKits = Item::where('category', 'Emergency Kits')->get();
        $otherItems = Item::where('category', 'Other Item')->get();
        $archivedItems = Item::onlyTrashed()->get(); // Assuming you're using soft deletes
        
        // Fetch archived items
        $archivedItems = Item::where('is_archived', true)->get();

        return view('inven', compact('allItems', 'items', 'officeSupplies', 'emergencyKits', 'otherItems', 'archivedItems'));
    }

    // Archive an item
    public function archiveItem($id)
    {
        $item = Item::find($id);
        if ($item) {
            $item->is_archived = true; // Mark as archived
            $item->save();
        }

        return redirect()->route('inventory'); // Redirect to the inventory page
    }

    // Restore an item from the archive
    public function restoreItem($id)
    {
        $item = Item::find($id);
        if ($item) {
            $item->is_archived = false; // Mark as not archived
            $item->save();
        }

        return redirect()->route('inventory'); // Redirect to the inventory page
    }

    // Update an item (edit functionality)
    public function editItem(Request $request, $id)
    {
        // Find the item by ID
        $item = Item::findOrFail($id);

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

        // Update the item with the new data
        $item->name = $request->input('name');
        $item->category = $request->input('category');
        $item->quantity = $request->input('quantity');
        $item->unit = $request->input('unit');
        $item->description = $request->input('description');
        $item->storage_location = $request->input('storage_location');
        $item->arrival_date = $request->input('arrival_date');
        $item->date_purchased = $request->input('date_purchased');
        $item->status = $request->input('status');

        // Handle the image upload if a new image is included
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('images', 'public');
            $item->image_url = $imagePath; // Save the image URL
        }

        // Save the updated item to the database
        $item->save();

        // Return a success response
        return response()->json(['message' => 'Item updated successfully!']);
    }
}
