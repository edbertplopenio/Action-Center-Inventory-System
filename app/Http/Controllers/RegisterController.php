<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Validate input data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'department' => 'required|string|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        try {
            // Create new user
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'department' => $request->department,
                'password' => Hash::make($request->password),
            ]);

            // Optionally, log the user in immediately after registration
            // Auth::login($user);

            // Redirect with success message
            return redirect()->route('login')->with('status', 'registration_success');
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'error')->withErrors(['message' => 'Something went wrong!']);
        }
    }
}
