<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\IndividualItem;
use App\Models\BorrowedItem;
use DB;
use Carbon\Carbon;

class ItemController extends Controller
{
    /**
     * Display a listing of the items.
     */
    public function index()
    {
        $currentTime = Carbon::now();  // Get current time

        // Fetch all items, sorted by the added_at field in descending order (most recent first)
        $allItems = Item::where('is_archived', false)
                        ->orderBy('added_at', 'desc')
                        ->get()
                        ->map(function($item) use ($currentTime) {
                            // Calculate the time difference in days and check if it's within 5 days
                            $item->is_new = $currentTime->diffInDays($item->added_at) <= 5;
                            return $item;
                        });

        // Fetch categorized items in descending order by added_at
        $drrmItems = Item::where('is_archived', false)
                         ->where('category', 'DRRM Equipment')
                         ->orderBy('added_at', 'desc')
                         ->get()
                         ->map(function($item) use ($currentTime) {
                             $item->is_new = $currentTime->diffInDays($item->added_at) <= 5;
                             return $item;
                         });

        $officeItems = Item::where('is_archived', false)
                           ->where('category', 'Office Supplies')
                           ->orderBy('added_at', 'desc')
                           ->get()
                           ->map(function($item) use ($currentTime) {
                               $item->is_new = $currentTime->diffInDays($item->added_at) <= 5;
                               return $item;
                           });

        $emergencyItems = Item::where('is_archived', false)
                              ->where('category', 'Emergency Kits')
                              ->orderBy('added_at', 'desc')
                              ->get()
                              ->map(function($item) use ($currentTime) {
                                  $item->is_new = $currentTime->diffInDays($item->added_at) <= 5;
                                  return $item;
                              });

        $otherItems = Item::where('is_archived', false)
                          ->where('category', 'Other Items')
                          ->orderBy('added_at', 'desc')
                          ->get()
                          ->map(function($item) use ($currentTime) {
                              $item->is_new = $currentTime->diffInDays($item->added_at) <= 5;
                              return $item;
                          });

        // Fetch archived items
        $archivedItems = Item::where('is_archived', true)->get();
 // Fetch the most available item(s) based on quantity
        $mostAvailableItems = Item::where('is_archived', false)
            ->orderBy('quantity', 'desc')
            ->take(1)
            ->get();
    
        // Fetch critical stock items (items with the lowest quantity)
        $criticalStockItems = Item::where('is_archived', false)
            ->orderBy('quantity', 'asc')
            ->take(1)
            ->get();
    
        // Fetch the most recent deployment (borrowed item)
        $recentDeploymentFirst = BorrowedItem::with('item') 
            ->orderBy('borrow_date', 'desc')
            ->take(1)
            ->get();
    
        // Fetch top 3 low stock items
        $lowStockItems = Item::where('is_archived', false)
            ->orderBy('quantity', 'asc')
            ->take(3)
            ->get();
    
        // Fetch items that need repair
        $itemsNeedingRepair = Item::where('status', 'Needs Repair')
            ->where('is_archived', false)
            ->get();
    
        // Fetch the next 10 recent deployments
        $recentDeploymentsNext = BorrowedItem::with('item') 
            ->orderBy('borrow_date', 'desc')
            ->skip(1)
            ->take(10)
            ->get();
    
        // Fetch distinct equipment names with their ids, ensuring no duplicates
        $equipment = Item::where('is_archived', false)
            ->distinct('name')
            ->get(['id', 'name']);  // Select only the id and name columns

        // Join 'borrowed_items' with 'items' to fetch item names along with the borrowed quantities
        $mostBorrowedItems = DB::table('borrowed_items')
            ->join('items', 'borrowed_items.item_id', '=', 'items.id')  // Join on item_id
            ->select('items.name as item_name', DB::raw('SUM(borrowed_items.quantity_borrowed) as total_borrowed'))
            ->groupBy('items.name')  // Group by item_name
            ->orderBy('total_borrowed', 'desc')  // Order by total borrowed quantity
            ->get();
    
        // Fetch the sum of quantities grouped by category
        $categoryCounts = DB::table('items')
            ->select('category', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('category')
            ->get();

        // Pass all variables to the view
        return view('home', compact(
            'allItems', 
            'drrmItems', 
            'officeItems', 
            'emergencyItems', 
            'otherItems', 
            'archivedItems', 
            'mostAvailableItems',
            'criticalStockItems',
            'recentDeploymentFirst',
            'lowStockItems',
            'itemsNeedingRepair',
            'recentDeploymentsNext',
            'equipment', // Ensure equipment is passed to the view
            'mostBorrowedItems',
            'categoryCounts'
        ));
    }

    // Fetch all items (equipment)
// Fetch item details for editing via AJAX
public function getItemData($id)
{
    // Fetch item data from the database by its ID
    $item = Item::find($id);

    // If the item is not found, return an error response
    if (!$item) {
        return response()->json(['error' => 'Item not found.'], 404);
    }

    // Return the item data in JSON format
    return response()->json($item);
}

    // Fetch usage rate data for a specific item
    public function getUsageRateData($itemId)
    {
        // Retrieve usage data for the selected item (quantity borrowed per month)
        $usageData = BorrowedItem::where('item_id', $itemId)
            ->selectRaw('MONTH(borrow_date) as month, SUM(quantity_borrowed) as total_borrowed')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Prepare the response data
        $labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']; // Month names
        $data = array_fill(0, 12, 0); // Default to 0 for each month

        // Fill the data for each month from the database
        foreach ($usageData as $usage) {
            $data[$usage->month - 1] = $usage->total_borrowed; // Store the total borrowed count for each month
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }



    // Fetch item details for borrowing and make necessary changes
    public function borrowItem(Request $request, $itemId)
    {
        // Fetch the item from the database by ID
        $item = Item::findOrFail($itemId);

        // Check if the item is consumable
        if ($item->is_consumable) {
            // For consumable items, reduce quantity and mark as borrowed
            if ($item->quantity >= $request->quantity) {
                $item->quantity -= $request->quantity; // Decrease the quantity
                $item->status = 'Borrowed'; // Set status to 'Borrowed'
                $item->save(); // Save the changes

                // Record the borrowing in the BorrowedItem table
                $borrowedItem = new BorrowedItem();
                $borrowedItem->item_id = $item->id;
                $borrowedItem->quantity_borrowed = $request->quantity;
                $borrowedItem->borrow_date = now(); // Record the borrowing date
                $borrowedItem->save(); // Save the record

                // Return a success response
                return response()->json(['message' => 'Consumable item borrowed successfully.'], 200);
            } else {
                return response()->json(['error' => 'Not enough stock for this consumable item.'], 400);
            }
        } else {
            // For non-consumable items, borrow them without reducing quantity
            $item->status = 'Borrowed'; // Set status to 'Borrowed'
            $item->save(); // Save the change

            // Record the borrowing
            $borrowedItem = new BorrowedItem();
            $borrowedItem->item_id = $item->id;
            $borrowedItem->quantity_borrowed = $request->quantity;
            $borrowedItem->borrow_date = now(); // Record the borrow date
            $borrowedItem->save(); // Save the record

            return response()->json(['message' => 'Non-consumable item borrowed successfully.'], 200);
        }
    }



    /**
     * Store items in the database.
     */
    public function store(Request $request)
    {
        // Validate all possible fields
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'storage_location' => 'required|string|max:255',
            'other_storage_location' => 'nullable|string|max:255',
            'arrival_date' => 'required|date',
            'status' => 'required|string|max:255',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'brand' => 'nullable|string|max:255',
            'expiration_date' => 'nullable|date',
            'date_tested_inspected' => 'nullable|date',
            'consumable' => 'nullable|boolean',  // 'consumable' field can be nullable and boolean
            'inventory_date' => 'required|date',
        ]);
    
        // Final storage location (if "Other" storage location is selected)
        $storageLocation = $request->storage_location === 'Other'
            ? $request->other_storage_location
            : $request->storage_location;
    
        // Boolean handling for 'consumable'
        $isConsumable = $request->has('consumable') && $request->consumable == '1'; // If 'consumable' is checked
    
        // Check if item exists by name and category
        $item = Item::where('name', $request->name)
                    ->where('category', $request->category)
                    ->first();
    
        if ($item) {
            // If the item exists, we just update the quantity
            $item->quantity += $request->quantity;
        } else {
            // If the item doesn't exist, we create a new one
            $item = new Item();
            $item->name = $request->name;
            $item->quantity = $request->quantity;
    
            // Generate item code (item_code) based on category and name
            $categoryMap = [
                'DRRM Equipment' => 'DRRM',
                'Office Supplies' => 'Office',
                'Emergency Kits' => 'Emergency',
                'Other Items' => 'Other',
            ];
            $abbr = $categoryMap[$request->category] ?? strtoupper($request->category);
            $itemCount = Item::where('category', $request->category)->count();
            $itemInitials = collect(explode(' ', strtoupper($request->name)))
                ->map(fn($part) => substr($part, 0, 1))
                ->implode('');
            if (strlen($itemInitials) < 2) {
                $itemInitials = strtoupper(substr($request->name, 0, 2));
            }
            $item->item_code = "{$abbr}-" . str_pad($itemCount + 1, 2, '0', STR_PAD_LEFT) . "-{$itemInitials}";
            $item->added_at = now();
        }
    
        // Common field assignments
        $item->unit = $request->unit;
        $item->category = $request->category;
        $item->description = $request->description;
        $item->storage_location = $storageLocation;
        $item->arrival_date = $request->arrival_date;
        $item->status = $request->status;
        $item->brand = $request->brand;
        $item->date_tested_inspected = $request->date_tested_inspected;
        $item->expiration_date = $request->expiration_date;
        $item->is_consumable = $isConsumable; // Corrected to use 'is_consumable' field in the database
        $item->inventory_date = $request->inventory_date;
    
        // Handle file upload for image
        if ($request->hasFile('image_url')) {
            $filename = time() . '.' . $request->image_url->extension();
            $request->image_url->move(public_path('images'), $filename);
            $item->image_url = 'images/' . $filename;
        }
    
        // Save the item in the database
        $item->save();
    
        // Redirect back with success message
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
     * Fetch item details for editing.
     */
    public function editItem($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['error' => 'Item not found.'], 404);
        }

        return response()->json($item);
    }



    /**
     * Update
     */
    public function update(Request $request, $id)
    {
        // Fetch the item from the database using the ID
        $item = Item::find($id);
    
        // If the item is not found, return an error response
        if (!$item) {
            return response()->json(['error' => 'Item not found.'], 404);
        }
    
        // Validate the input fields for update
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'storage_location' => 'required|string|max:255',
            'arrival_date' => 'required|date',
            'status' => 'required|string|max:255',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'brand' => 'nullable|string|max:255',
            'expiration_date' => 'nullable|date',
            'date_tested_inspected' => 'nullable|date',
            'inventory_date' => 'nullable|date',
        ]);
    
        // Save the old quantity to compare later
        $oldQuantity = $item->quantity;
    
        // Update the editable fields
        $item->quantity = $validated['quantity'];
        $item->storage_location = $validated['storage_location'];
        $item->arrival_date = $validated['arrival_date'];
        $item->status = $validated['status'];
        $item->brand = $validated['brand'];
        $item->expiration_date = $validated['expiration_date'] ?? null;
        $item->date_tested_inspected = $validated['date_tested_inspected'] ?? null;
        $item->inventory_date = $validated['inventory_date'] ?? null;
    
        // Boolean handling for 'consumable'
        $item->is_consumable = $request->has('consumable') && $request->consumable == '1';
    
        // Handle image upload if provided
        if ($request->hasFile('image_url')) {
            $filename = time() . '.' . $request->image_url->extension();
            $request->image_url->move(public_path('images'), $filename);
            $item->image_url = 'images/' . $filename;
        }
    
        // Save the updated item
        $item->save();
    
        // Adjust the individual items table based on the quantity change
        if ($validated['quantity'] < $oldQuantity) {
            $this->removeIndividualItems($item, $oldQuantity - $validated['quantity']);
        } elseif ($validated['quantity'] > $oldQuantity) {
            $this->addIndividualItems($item, $validated['quantity'] - $oldQuantity);
        }
    
        // Return a success response with the updated item data
        return response()->json([
            'success' => true,
            'message' => 'Item updated successfully!',
            'item' => $item
        ]);
    }
        
    // Add individual items based on the quantity increase.
    private function addIndividualItems($item, $quantityToAdd)
    {
        $itemCode = $item->item_code;
        $currentQuantity = $item->quantity;
    
        // Generate individual item codes for the new quantity
        for ($i = $currentQuantity - $quantityToAdd + 1; $i <= $currentQuantity; $i++) {
            $individualItemCode = $itemCode . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
    
            // Create individual item entry
            $individualItem = new IndividualItem();
            $individualItem->item_id = $item->id;
            $individualItem->qr_code = $individualItemCode;  // Store the QR code string
            $individualItem->status = $item->status;
            $individualItem->save();
        }
    }
    
    // Remove individual items based on the quantity decrease.
    private function removeIndividualItems($item, $quantityToRemove)
    {
        $individualItems = IndividualItem::where('item_id', $item->id)
                                          ->orderBy('id', 'desc') // Get the latest added items first
                                          ->take($quantityToRemove)
                                          ->get();
    
        foreach ($individualItems as $individualItem) {
            $individualItem->delete(); // Delete the individual item
        }
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