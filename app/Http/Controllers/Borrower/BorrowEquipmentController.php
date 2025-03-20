<?php

namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BorrowEquipmentController extends Controller
{
    public function index()
    {
        return view('borrower.borrow-equipment.index');  // Path to the Borrower Borrow Equipment view
    }
}