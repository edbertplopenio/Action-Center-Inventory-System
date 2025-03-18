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

        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('images', 'public');
        } else {
            $imagePath = null;
        }

        $item = Item::withTrashed()->where('name', $request->name)->first();

        if ($item) {
            if ($item->trashed()) {
                $item->restore();
            }

            $item->quantity += $request->quantity;
            $item->arrival_date = $request->arrival_date;

            if ($imagePath) {
                $item->image_url = $imagePath;
            }

            $item->save();
            return redirect()->route('inventory')->with('success', 'Item quantity updated successfully!');
        } else {
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

    // Fetch all items
    public function index()
    {
        $allItems = Item::all();
        $items = Item::where('category', 'DRRM Equipment')->get();
        $officeSupplies = Item::where('category', 'Office Supplies')->get();
        $emergencyKits = Item::where('category', 'Emergency Kits')->get();
        $otherItems = Item::where('category', 'Other Items')->get();
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
        $item->delete();
        return response()->json(['message' => 'Item archived successfully!']);
    }

    // Restore an archived item
    public function restoreItem($id)
    {
        $item = Item::onlyTrashed()->findOrFail($id);
        $item->restore();
        return response()->json(['message' => 'Item restored successfully!']);
    }

    // ✅ Fetch item details for AJAX edit
    public function editItem($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item not found'], 404);
        }

        return response()->json(['success' => true, 'item' => $item]);
    }

    // ✅ Updated Update Method - Only Editable Fields
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'quantity' => 'required|integer',
            'description' => 'nullable|string',
            'storage_location' => 'required|string|max:255',
            'arrival_date' => 'required|date',
            'status' => 'required|string|max:100',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Only update editable fields
        $item->quantity = $request->quantity;
        $item->description = $request->description;
        $item->storage_location = $request->storage_location;
        $item->arrival_date = $request->arrival_date;
        $item->status = $request->status;

        // Handle Image Upload
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('images', 'public');
            $item->image_url = $imagePath;
        }

        $item->save();

        return response()->json(['success' => true, 'message' => 'Item updated successfully']);
    }
}
