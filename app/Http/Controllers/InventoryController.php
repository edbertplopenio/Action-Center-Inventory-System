<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment; // Ensure this model exists

class InventoryController extends Controller
{
    public function index()
    {
        // Fetch all inventory items from the database
        $items = Equipment::all(); 

        // Pass data to the inventory view
        return view('inventory.index', compact('items'));
    }
}

