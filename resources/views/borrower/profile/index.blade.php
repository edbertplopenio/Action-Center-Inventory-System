@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <!-- This is the container with the specified width and height -->
    <div class="mx-auto p-2" style="width: 1220px; height: 700px; font-family: 'Inter', sans-serif;">
        <div class="container mx-auto py-6">
            <h1 class="text-2xl font-semibold mb-4">Edit Profile</h1>

            @if(session('success'))
                <div id="success-message" class="bg-green-500 text-white p-2 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Cover Photo Section -->
            <div class="flex flex-col items-center mt-16 mb-8">
                <div class="w-[1000px] h-[200px] border border-gray-400 flex items-center justify-center mb-4">
                    <!-- Cover Image Display -->
                    <img id="cover-image-display" 
     src="{{ asset('storage/' . ($user->cover_image ?? 'default_cover.jpg')) }}" 
     alt="Cover Image" class="w-full h-full object-cover" />
                </div>
                <input type="file" id="cover-image" name="cover_image" class="hidden" onchange="handleCoverImageSelect()" />
                <button type="button" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700" onclick="document.getElementById('cover-image').click();">
                    Change Cover Photo
                </button>
            </div>

            <form method="POST" action="{{ route('profile.index') }}" enctype="multipart/form-data" class="grid grid-cols-2 gap-12 items-start">
                @csrf
                @method('PUT')

                <!-- Profile Image Section -->
                <div class="flex flex-col items-center mt-16 mb-8">
                    <div class="w-52 h-52 rounded-full border border-gray-400 flex items-center justify-center mb-4">
                        <!-- Profile Image Display -->
                        <img id="profile-image-display" 
                             src="{{ asset('storage/' . ($user->profile_image ?? 'default_profile.jpg')) }}" 
                             alt="Profile Image" class="w-52 h-52 rounded-full object-cover" />
                    </div>
                    <input type="file" id="profile-image" name="profile_image" class="hidden" onchange="handleProfileImageSelect()" />
                    <button type="button" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700" onclick="document.getElementById('profile-image').click();">
                        Change
                    </button>
                </div>

                <!-- Form Fields (Right Side) -->
                <div class="flex flex-col space-y-6 mt-8">
                    <div class="flex items-center space-x-10">
                        <label class="text-gray-700 text-left w-40">First Name :</label>
                        <input type="text" name="first_name" value="{{ $user->first_name }}" class="w-64 px-3 py-2 border border-gray-300 rounded-md">
                    </div>

                    <div class="flex items-center space-x-10">
                        <label class="text-gray-700 text-left w-40">Last Name :</label>
                        <input type="text" name="last_name" value="{{ $user->last_name }}" class="w-64 px-3 py-2 border border-gray-300 rounded-md">
                    </div>

                    <div class="flex items-center space-x-10">
                        <label class="text-gray-700 text-left w-40">Email :</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="w-64 px-3 py-2 border border-gray-300 rounded-md">
                    </div>

                    <div class="flex items-center space-x-10">
                        <label class="text-gray-700 text-left w-40">Department :</label>
                        <input type="text" name="department" value="{{ $user->department }}" class="w-64 px-3 py-2 border border-gray-300 rounded-md">
                    </div>

                    <div class="flex items-center space-x-10">
                        <label class="text-gray-700 text-left w-40">Password :</label>
                        <input type="password" name="password" class="w-64 px-3 py-2 border border-gray-300 rounded-md">
                    </div>

                    <div class="flex items-center space-x-10">
                        <label class="text-gray-700 text-left w-40">Confirm Password :</label>
                        <input type="password" name="password_confirmation" class="w-64 px-3 py-2 border border-gray-300 rounded-md">
                    </div>

                    <div class="flex justify-center mt-25">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <script>
            // Handle Profile Image Selection
            function handleProfileImageSelect() {
                const fileInput = document.getElementById('profile-image');
                const file = fileInput.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const profileImageDisplay = document.getElementById('profile-image-display');
                        profileImageDisplay.src = event.target.result;
                    }
                    reader.readAsDataURL(file); // Read the selected image file as a data URL
                }
            }

            // Handle Cover Image Selection
            function handleCoverImageSelect() {
                const fileInput = document.getElementById('cover-image');
                const file = fileInput.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const coverImageDisplay = document.getElementById('cover-image-display');
                        coverImageDisplay.src = event.target.result; // Update the cover image display
                    }
                    reader.readAsDataURL(file); // Read the selected image file as a data URL
                }
            }

            // Automatically hide success message after 3 seconds
            window.addEventListener('DOMContentLoaded', function() {
                const successMessage = document.getElementById('success-message');
                if (successMessage) {
                    setTimeout(function() {
                        successMessage.style.display = 'none'; // Hide the success message after 5 seconds
                    }, 3000);
                }
            });
        </script>
    </div>
@endsection
