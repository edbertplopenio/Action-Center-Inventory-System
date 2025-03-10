<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class RecordsController extends Controller
{
    public function index()
    {
        return view('admin.records.index');  // Ensure this view exists
    }
}
