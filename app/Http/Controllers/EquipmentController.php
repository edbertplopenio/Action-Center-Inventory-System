<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
   use Illuminate\Support\Facades\DB;

class EquipmentController extends Controller
{
    public function index()
    {
        // Fetch all equipment from the database
        $items = Equipment::all();

        // Pass the fetched data to the view
        return view('inventory', compact('items'));
    }

        public function mostBorrowedEquipment()
        {
            $mostBorrowed = DB::table('borrowed_equipment')
                ->select('item_name', DB::raw('COUNT(*) as count'))
                ->groupBy('item_name')
                ->orderByDesc('count')
                ->take(5)
                ->pluck('count', 'item_name');
        
            return response()->json($mostBorrowed); // Correct variable here
        }
        


    }
    
