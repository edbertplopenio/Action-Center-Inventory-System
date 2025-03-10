<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthManager extends Controller
{
    // Show login form
    public function login()
    {
        return view('login');
    }

    // Show registration form
    public function registration()
    {
        return view('registration');
    }

    // Handle login request
    public function loginPost(Request $request)
    {
        // Validate login data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt to log in with credentials
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Redirect to home page on successful login
            return redirect()->route('home')->with("status", "success");
        }

        // Redirect back with error if login fails
        return redirect(route('login'))->with("status", "error");
    }

    // Handle registration request
    public function registrationPost(Request $request)
    {
        // Validate registration data
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed', // Ensure password confirmation
            'department' => 'required',
            'cellphone_number' => 'required'
        ]);

        // Prepare data for new user
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
            'department' => $request->department,
            'cellphone_number' => $request->cellphone_number
        ];

        // Create new user in the database
        $user = User::create($data);

        // Check if user creation was successful
        if (!$user) {
            return redirect(route('registration'))->with("status", "error");
        }

        // Redirect to login page after successful registration
        return redirect(route('login'))->with("status", "success");
    }

    // Handle logout request
    public function logout()
    {
        // Clear session and log out the user
        Session::flush();
        Auth::logout();

        // Redirect to login page after logout
        return redirect(route('login'));
    }
}
