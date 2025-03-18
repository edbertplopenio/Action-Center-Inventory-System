<?php
// app/Http/Controllers/Admin/InventoryRequestController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class InventoryRequestController extends Controller
{
    public function index()
    {
        return view('admin.inventory-requests.index');
    }
}
