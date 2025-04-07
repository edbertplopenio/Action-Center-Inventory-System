<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipmentUsageController extends Controller
{
    public function getUsageData(Request $request)
    {
        $itemId = $request->query('item_id');

        // Fetch usage count per month based on borrow_date
        $usageData = DB::table('borrowed_items')
            ->selectRaw('MONTHNAME(borrow_date) as month, COUNT(*) as usage_count')
            ->where('item_id', $itemId)
            ->groupByRaw('MONTH(borrow_date)')
            ->orderByRaw('MONTH(borrow_date)')
            ->get();

        return response()->json([
            'months' => $usageData->pluck('month'),
            'usage' => $usageData->pluck('usage_count'),
        ]);
    }
}
