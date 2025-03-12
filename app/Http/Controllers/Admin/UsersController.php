<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        // Fetch only active users
        $users = User::where('status', 'active')->get();
    
        // Pass active users to the Blade view
        return view('admin.users.index', compact('users'));
    }
    

    /**
     * Store a new user.
     */
    public function store(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'user_role' => 'required|string',
            'department' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|regex:/^[0-9]{10,15}$/',
            'password' => 'required|min:6|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Handle file upload
        $photoPath = null;
        if ($request->hasFile('profile_picture')) {
            $photoPath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }
    
        // Create new user with status = active
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'user_role' => $request->input('user_role'),
            'department' => $request->input('department'),
            'contact_number' => $request->input('contact_number'),
            'password' => Hash::make($request->input('password')),
            'profile_picture' => $photoPath,
            'status' => 'active' // ✅ Ensure new users are active
        ]);
    
        return response()->json([
            'status' => 'success',
            'message' => 'User added successfully!',
            'user' => $user
        ], 201);
    }
    
    /**
     * Get a specific user's data for editing.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Update user data.
     */
    public function update(Request $request, $id)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,$id",
            'user_role' => 'required|string',
            'department' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|regex:/^[0-9]{10,15}$/',
            'password' => 'nullable|min:6|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max size: 2MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Find the user
        $user = User::findOrFail($id);

        // Check if any changes were made
        $newData = $request->except(['password', 'password_confirmation', 'profile_picture']);

        if (!$request->filled('password')) {
            unset($newData['password']);
        }

        $oldData = $user->only(array_keys($newData));

        if ($newData === $oldData && !$request->hasFile('profile_picture')) {
            return response()->json([
                'status' => 'no_changes',
                'message' => 'No changes detected. Update not required.'
            ], 200);
        }

        // Handle file upload
        if ($request->hasFile('profile_picture')) {
            // Delete old photo if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Upload new photo
            $photoPath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $photoPath;
        }

        // Update user details
        $user->update($newData);

        // Update password only if provided
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->input('password')),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully!',
            'user' => $user
        ], 200);
    }

    /**
     * Delete user profile picture.
     */
    public function deleteProfilePicture($id)
    {
        $user = User::findOrFail($id);

        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
            $user->profile_picture = null;
            $user->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Profile picture removed successfully.'
        ]);
    }




public function deactivatedIndex()
{
    // Fetch only deactivated users
    $users = User::where('status', 'deactivated')->get();

    // Pass deactivated users to the Blade view
    return view('admin.users.deactivated', compact('users'));
}

    




    public function deactivate($id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['success' => false, 'message' => 'User not found.']);
    }

    // Update status to 'deactivated'
    $user->update(['status' => 'deactivated']);

    return response()->json(['success' => true, 'message' => 'User successfully deactivated.']);
}



public function activate($id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['success' => false, 'message' => 'User not found.'], 404);
    }

    // Update the status to 'active'
    $user->update(['status' => 'active']);

    return response()->json(['success' => true, 'message' => 'User successfully activated.']);
}




}



