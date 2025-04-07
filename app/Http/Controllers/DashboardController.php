<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getEquipmentByCategory()
{
    $data = DB::table('equipment')
        ->join('categories', 'equipment.category_id', '=', 'categories.id')
        ->select('categories.name as category', DB::raw('count(*) as total'))
        ->groupBy('categories.name')
        ->pluck('total', 'category');

    return response()->json($data);
}

}
