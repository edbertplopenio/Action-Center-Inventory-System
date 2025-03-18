<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    public function index()
    {
        // Fetch all equipment from the database
        $items = Equipment::all();

        // Pass the fetched data to the view
        return view('inventory', compact('items'));
    }
}
