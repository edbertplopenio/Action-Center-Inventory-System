<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item; // Import the Item model

class InventoryController extends Controller
{
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

        // Pass the fetched data to the view
        return view('admin.inventory.index', compact('allItems', 'drrmItems', 'officeItems', 'emergencyItems', 'otherItems', 'archivedItems'));
    }
}