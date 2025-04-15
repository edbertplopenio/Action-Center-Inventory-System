<?php

namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the profile form for editing.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch the logged-in user
        $user = auth()->user();

        // Return the view with the user data
        return view('borrower.profile.index', compact('user'));
    }

    /**
     * Update the profile information.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'nullable|confirmed|min:8',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation for image
    ]);

    $user = auth()->user();

    // Handle profile image upload
    if ($request->hasFile('profile_image')) {
        // Store the new profile image
        $path = $request->file('profile_image')->store('profile_images', 'public');
        $user->profile_image = $path;
    }

    // Handle other fields (name, email, etc.)
    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->email = $request->email;
    $user->department = $request->department;

    if ($request->password) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
}

}