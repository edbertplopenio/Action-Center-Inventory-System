<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    // Display the form to create a new item
    public function create()
    {
        return view('item-form');
    }

    // Store or update an item
    public function store(Request $request)
    {
        // Validate input data
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
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('images', 'public');
        } else {
            $imagePath = null;
        }

        // Check if the item exists (including soft-deleted items)
        $item = Item::withTrashed()->where('name', $request->name)->first();

        if ($item) {
            if ($item->trashed()) {
                // If item was archived, restore it
                $item->restore();
            }

            // Update the quantity and arrival date
            $item->quantity += $request->quantity;
            $item->arrival_date = $request->arrival_date;

            if ($imagePath) {
                $item->image_url = $imagePath;
            }

            $item->save();
            return redirect()->route('inventory')->with('success', 'Item quantity updated successfully!');
        } else {
            // Create a new item
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

            return redirect()->route('inventory')->with('success', 'Item added successfully!');
        }
    }

    // Display all active and archived items
    public function index()
    {
        $allItems = Item::whereNull('deleted_at')->get();
        $items = Item::where('category', 'DRRM Equipment')->whereNull('deleted_at')->get();
        $officeSupplies = Item::where('category', 'Office Supplies')->whereNull('deleted_at')->get();
        $emergencyKits = Item::where('category', 'Emergency Kits')->whereNull('deleted_at')->get();
        $otherItems = Item::where('category', 'Other Items')->whereNull('deleted_at')->get();
        $archivedItems = Item::onlyTrashed()->get();

        return view('inventory', compact('allItems', 'items', 'officeSupplies', 'emergencyKits', 'otherItems', 'archivedItems'));
    }

    // Archive an item (soft delete)
    public function archive($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found!'], 404);
        }

        $item->delete(); // Soft delete the item

        return response()->json(['message' => 'Item archived successfully!']);
    }

    // Restore an archived item
    public function restoreItem($id)
    {
        $item = Item::onlyTrashed()->findOrFail($id);
        $item->restore(); // Restore the item

        return response()->json(['message' => 'Item restored successfully!']);
    }

    // Edit an item
    public function editItem(Request $request, $id)
    {
        try {
            // Find the item by ID
            $item = Item::findOrFail($id);

            // Validate input fields
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
                'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Update item fields
            $item->name = $request->input('name');
            $item->category = $request->input('category');
            $item->quantity = $request->input('quantity');
            $item->unit = $request->input('unit');
            $item->description = $request->input('description');
            $item->storage_location = $request->input('storage_location');
            $item->arrival_date = $request->input('arrival_date');
            $item->date_purchased = $request->input('date_purchased');
            $item->status = $request->input('status');

            // Handle image upload if a new image is uploaded
            if ($request->hasFile('image_url')) {
                // Store the image and update the item's image URL
                $imagePath = $request->file('image_url')->store('images', 'public');
                $item->image_url = $imagePath;
            }

            // Save the updated item
            $item->save();

            return response()->json(['message' => 'Item updated successfully!']);
        } catch (\Exception $e) {
            \Log::error('Error updating item: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to update item. Please try again.'], 500);
        }
    }
}
