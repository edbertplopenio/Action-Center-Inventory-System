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
        // Fetch all items from the database, ordered by created_at in descending order
        $items = Item::orderBy('created_at', 'desc')->get();  // Adjust the field to order by as needed
    
        // Pass the items data to the view
        return view('borrower.inventory.index', compact('items'));  // Points to the Borrower Inventory view
    }
    
}
