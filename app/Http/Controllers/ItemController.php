<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\IndividualItem;

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
     * Store items in the database.
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
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Check if the item already exists (same name & category)
        $item = Item::where('name', $request->name)
                    ->where('category', $request->category)
                    ->first();

        if ($item) {
            // If item exists, update quantity and dates
            $item->quantity += $request->quantity;  // Add the new quantity
            $item->arrival_date = $request->arrival_date; 
            $item->date_purchased = $request->date_purchased;
            $item->save();

            // Generate individual items for the new quantity added
            $this->generateIndividualItems($item, $request->quantity);
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

            // Handle image upload if provided and save URL to `image_url`
            if ($request->hasFile('image_url')) {
                $filename = time() . '.' . $request->image_url->extension();
                $request->image_url->move(public_path('images'), $filename);
                $item->image_url = 'images/' . $filename;
            }

            // Generate item code based on category abbreviation and count of items in that category
            $category = $request->category;

            // Map categories to their abbreviations
            $categoryMap = [
                'DRRM Equipment' => 'DRRM',
                'Office Supplies' => 'Office',
                'Emergency Kits' => 'Emergency',
                'Other Items' => 'Other',
            ];

            // Get the abbreviation for the category
            $categoryAbbreviation = isset($categoryMap[$category]) ? $categoryMap[$category] : strtoupper($category);

            // Count how many items are in this category
            $itemCount = Item::where('category', $category)->count();

            // Process item name to get initials if it's more than 8 characters or has more than one word
            $itemName = strtoupper($request->name); // Uppercase the item name
            $nameParts = explode(' ', $itemName); // Split the name into words
            $itemInitials = '';

            if (count($nameParts) > 1 || strlen($itemName) > 8) {
                // Take the first letter of each word for names with more than 1 word or > 8 chars
                foreach ($nameParts as $part) {
                    $itemInitials .= strtoupper(substr($part, 0, 1)); // Take the first letter of each word
                }
            } else {
                $itemInitials = strtoupper(substr($itemName, 0, 2)); // Otherwise, take first 2 letters
            }

            // Generate a single item code for the new item
            $itemCode = $categoryAbbreviation . '-' . str_pad($itemCount + 1, 2, '0', STR_PAD_LEFT) . '-' . $itemInitials;

            // Store the item code
            $item->item_code = $itemCode;

            $item->save();

            // Generate individual items based on quantity
            $this->generateIndividualItems($item, $request->quantity);
        }

        return redirect()->back()->with('success', 'Item added/updated successfully!');
    }

    /**
     * Generate individual items for the added quantity.
     */
    private function generateIndividualItems($item, $quantity)
    {
        // Generate individual items based on the added quantity
        $itemCode = $item->item_code;
        $currentQuantity = $item->quantity;

        // Generate new individual item codes for the new quantity
        for ($i = $currentQuantity - $quantity + 1; $i <= $currentQuantity; $i++) {
            $individualItemCode = $itemCode . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);

            // Create individual item entry
            $individualItem = new IndividualItem();
            $individualItem->item_id = $item->id;
            $individualItem->qr_code = $individualItemCode;  // Store the QR code string
            $individualItem->status = $item->status;
            $individualItem->save();
        }
    }

    /**
     * Fetch and return item details for editing or populating the form.
     */
    public function searchItem($name)
    {
        $item = Item::where('name', 'like', '%' . $name . '%')->first();

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

        // Handle image upload if provided and save URL to `image_url`
        if ($request->hasFile('image_url')) {
            $filename = time() . '.' . $request->image_url->extension();
            $request->image_url->move(public_path('images'), $filename);
            $item->image_url = 'images/' . $filename;
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
