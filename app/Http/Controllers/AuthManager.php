<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;
use Illuminate\Support\Str;


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
        $request->validate([
            'email'    => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/'],
            'password' => 'required'
        ]);

        // Find user first
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->route('login')->with("status", "login_error");
        }

        // Check if user is inactive
        if ($user->status !== 'active') {
            return redirect()->route('login')->with("status", "inactive_account");
        }

        // Login the user
        Auth::login($user);

        // Redirect based on role
        if ($user->user_role === 'Borrower') {
            return redirect()->route('borrower.inventory.index')->with("status", "login_success");
        }

        return redirect()->route('home')->with("status", "login_success");
    }




    // Handle registration request
    public function registrationPost(Request $request)
    {
        $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'email' => [
                'required',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[\W_]/',
            ],
            'department'     => 'nullable|string|max:255',
            'contact_number' => ['nullable', 'regex:/^(09|\+639)\d{9}$/'],
        ]);

        $user = User::create([
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'department'     => $request->department,
            'contact_number' => $request->contact_number,
            'active'         => 0,
            'verification_token' => \Illuminate\Support\Str::random(40),

        ]);

        if (!$user) {
            return redirect()->route('registration')->with("status", "error");
        }

        // Send verification email
        Mail::to($user->email)->send(new VerificationEmail($user));

        return redirect()->route('registration')->with("status", "verification_pending");
    }

    // Add verification method
    public function verifyEmail($token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->with('status', 'invalid_token');
        }

        $user->update([
            'status' => 'active', // ✅ correct column
            'verification_token' => null,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('login')->with('status', 'verification_success');
    }


    // Handle logout request
    public function logout()
    {
        // Clear session and log out the user
        Session::flush();
        Auth::logout();

        // Redirect to login page after logout
        return redirect()->route('login');
    }




    // app/Http/Controllers/AuthManager.php


    // Other methods...

    public function validateEmail(Request $request)
    {
        // Validate the email format
        $request->validate([
            'email' => 'required|email',
        ]);

        // Check if the email exists in the database
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // If user exists, send success response
            return response()->json(['success' => true]);
        }

        // If user does not exist, send failure response
        return response()->json(['success' => false]);
    }
}