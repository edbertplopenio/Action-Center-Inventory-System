<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetching the most available equipment
        $mostAvailable = Item::orderBy('quantity', 'desc')->first();

        // Fetching the lowest stock equipment
        $criticalStock = Item::where('quantity', '<', 5)->orderBy('quantity', 'asc')->first();

        // Fetching items that need repair
        $needsRepair = Item::where('status', 'Under Maintenance')->orderBy('quantity', 'desc')->first();

        // Fetching recent deployments
        $recentDeployments = Item::orderBy('updated_at', 'desc')->take(5)->get();

        return view('dashboard', compact('mostAvailable', 'criticalStock', 'needsRepair', 'recentDeployments'));
    }
}
