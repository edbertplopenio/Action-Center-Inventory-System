<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BorrowedItem;
use Illuminate\Http\Request;

class InventoryRequestController extends Controller
{
    public function index()
    {
        // Fetch all borrowing requests with related item and borrower details
        $borrowing_requests = BorrowedItem::with(['item', 'borrower'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.inventory-requests.index', compact('borrowing_requests'));
    }
}
