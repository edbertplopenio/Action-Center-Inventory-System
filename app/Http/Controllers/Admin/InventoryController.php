<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        // Return the admin inventory view
        return view('admin.inventory.index');  // Path to the Admin Inventory view
    }
}
