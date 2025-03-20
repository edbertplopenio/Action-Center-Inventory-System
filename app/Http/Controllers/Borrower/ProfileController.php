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
        // Validate the incoming data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'password' => 'nullable|confirmed|min:6',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
            'department' => 'required|string|max:255',
        ]);
    
        // Fetch the logged-in user
        $user = auth()->user();
    
        // Update the user details
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->department = $request->department;
    
        // If password is provided, hash and update it
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        // If profile image is uploaded, save the image and update the user's profile image
        if ($request->hasFile('profile_image')) {
            // Delete the old profile image if exists
            if ($user->profile_image) {
                Storage::delete('public/' . $user->profile_image);
            }
    
            // Store the new image
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $imagePath;
        }
    
        // If cover image is uploaded, save the image and update the user's cover image
        if ($request->hasFile('cover_image')) {
            // Delete the old cover image if exists
            if ($user->cover_image) {
                Storage::delete('public/' . $user->cover_image);
            }
    
            // Store the new cover image
            $imagePath = $request->file('cover_image')->store('cover_images', 'public');
            $user->cover_image = $imagePath; // Save the path to the database
        }
    
        // Save the updated user information to the database
        $user->save();
    
        // Redirect back to the profile edit page with a success message
        return redirect()->route('profile.index')->with('success', 'Profile updated successfully!');
    }
    
}
