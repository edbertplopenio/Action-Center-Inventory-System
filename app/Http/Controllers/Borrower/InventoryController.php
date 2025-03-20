<?php

// app/Http/Controllers/InventoryController.php
namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        return view('borrower.inventory.index');  // Points to the Borrower Inventory view
    }
}


