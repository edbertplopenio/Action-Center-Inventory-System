<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\IndividualItem;
use App\Models\BorrowedItem;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
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

        // Retrieve all borrowed items with status 'pending' to show pending requests
        $borrowedItems = BorrowedItem::where('status', 'pending')->get();
        

     // Pass all variables to the view
     return view('home', compact(
    
         'mostAvailableItems',
         'criticalStockItems',
         'recentDeploymentFirst',
         'lowStockItems',
         'itemsNeedingRepair',
         'recentDeploymentsNext',
         'equipment', // Ensure equipment is passed to the view
         'mostBorrowedItems',
         'categoryCounts',
         'borrowedItems'
     ));
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
         $labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July','August', 'September', 'October', 'November','December']; // Month names
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

     
}