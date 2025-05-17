<?php

// app/Http/Controllers/InventoryController.php
namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use App\Models\Item;  // Import the Item model
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        // Fetch all items from the database
        $items = Item::all();  // You can customize this query as needed (e.g., pagination, filters)

        // Pass the items data to the view
        return view('borrower.inventory.index', compact('items'));  // Points to the Borrower Inventory view
    }
    
}