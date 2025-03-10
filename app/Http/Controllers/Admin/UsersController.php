<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        // You can fetch the users from the database here, for example:
        // $users = User::all();

        // For now, we will just return the view
        return view('admin.users.index');
    }
}

