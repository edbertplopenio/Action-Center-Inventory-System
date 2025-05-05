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
     * Show the form for editing the profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('borrower.profile.index', compact('user'));
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validate input
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'department' => 'nullable|string|max:255',
            'password'   => 'nullable|confirmed|min:8',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = auth()->user();

        // Update basic info
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->department = $request->department;

        // Update password if provided
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                // Optional: Delete old image if exists
                if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                    Storage::disk('public')->delete($user->profile_picture);
                }

                // Save new image
                $path = $request->file('profile_image')->store('profile_pictures', 'public');
                $user->profile_picture = $path; // <<< ✅ save to profile_picture NOT profile_image
            }
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }
}