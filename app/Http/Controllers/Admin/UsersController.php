<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    // Display the list of users
    public function index()
    {
        // Get all users from the database
        $users = User::all(); // Fetch all users

        // Return the view and pass the users data
        return view('admin.users.index', compact('users'));
    }

    // Display the user profile
    public function show($id)
    {
        $user = User::findOrFail($id);  // Find user by ID
        return view('admin.users.show', compact('user'));  // Display user profile
    }

    // Update user profile
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);  // Find user by ID

        // Validate input fields
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for profile picture
        ]);

        // Update user info
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Handle profile photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && file_exists(storage_path('app/public/photos/' . $user->photo))) {
                unlink(storage_path('app/public/photos/' . $user->photo));
            }

            // Store new photo
            $path = $request->file('photo')->store('public/photos');
            $user->photo = basename($path);  // Save the file name in DB
        }

        // Handle profile picture upload (separate from photo)
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture && file_exists(storage_path('app/public/photos/' . $user->profile_picture))) {
                unlink(storage_path('app/public/photos/' . $user->profile_picture));
            }

            // Store new profile picture
            $path = $request->file('profile_picture')->store('public/photos');
            $user->profile_picture = basename($path);  // Save the file name in DB
        }

        // Save updated user info
        $user->save();

        return redirect()->route('users.show', $user->id)->with('success', 'Profile updated successfully!');
    }
}
