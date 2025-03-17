<?php

namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        // You can pass any necessary data here if needed
        return view('borrower.profile.index');  // Path to the profile view
    }
}


