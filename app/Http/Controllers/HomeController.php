<?php

// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Item; // Make sure to import your Item model
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch the most available items (you can adjust the query as needed)
        $mostAvailableItems = Item::where('quantity', '>', 0) // Ensure you only fetch items with available stock
            ->orderBy('quantity', 'desc') // Order items by quantity in descending order
            ->take(5) // Limit to 5 items (you can change this based on your needs)
            ->get(); // Retrieve the items

        // Pass the data to the view
        return view('home', compact('mostAvailableItems'));
    }
}
