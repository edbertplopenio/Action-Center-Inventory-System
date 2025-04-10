<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        // ✅ Most Borrowed Equipment (fix: use items.item_name instead of items.name)
        $mostBorrowed = DB::table('borrowed_equipment')
            ->join('items', 'borrowed_equipment.item_id', '=', 'items.id')
            ->select('items.item_name', DB::raw('COUNT(*) as borrow_count'))
            ->groupBy('items.item_name')
            ->orderByDesc('borrow_count')
            ->limit(5)
            ->get();
    
        // ✅ Equipment Quantity by Category
        $equipmentByCategory = DB::table('items')
            ->select('category', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('category')
            ->get();
    
        return view('home', compact('mostBorrowed', 'equipmentByCategory'));
    }
    
}
