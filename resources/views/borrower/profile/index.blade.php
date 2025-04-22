@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <!-- Include Font Awesome for the Pen Icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Background Image -->
    <img class="absolute w-full h-full object-cover" src="{{ asset('images/bg.png') }}" alt="Background Image" style="z-index: -1;"/>

    <!-- Content Form Section with Flexbox for equal space -->
    <div class="flex justify-between items-center h-full px-24">
        <!-- This is the container with the specified width and height -->
        <div class="mx-auto p-2 overflow-hidden" style="max-width: 1220px; max-height: 700px; font-family: 'Inter', sans-serif;">
            <div class="container mx-auto py-6">
                <h1 class="text-5xl font-semibold mb-4 text-white">Edit Profile</h1>

                @if(session('success'))
                    <div id="success-message" class="bg-green-500 text-white p-2 mb-4 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.index') }}" enctype="multipart/form-data" class="grid grid-cols-2 gap-12 items-start">
                    @csrf
                    @method('PUT')

                    <!-- Profile Image Section (Left Side) -->
                    <div class="flex flex-col items-center mt-16 mb-8">
                        <div class="w-72 h-72 rounded-full border border-white flex items-center justify-center mb-4 relative">
                            <!-- Profile Image Display -->
                            <img id="profile-image-display" 
     src="{{ asset('storage/' . ($user->profile_image ?? 'default_profile.jpg')) }}" 
     alt="Profile Image" class="w-72 h-72 rounded-full object-cover border-4 border-white" />

        
                            <!-- Edit Button inside the Frame (Lower Part) -->
                            <button type="button" class="absolute bottom-2 right-2 text-white border border-white rounded-full p-2 bg-blue-600 hover:bg-blue-700" 
                                    onclick="document.getElementById('profile-image').click();">
                                <i class="fas fa-pen"></i> <!-- Pen Icon -->
                            </button>
                        </div>
                        <input type="file" id="profile-image" name="profile_image" class="hidden" onchange="handleProfileImageSelect()" />
                    </div>

                    <!-- Form Fields (Right Side) -->
                    <div class="bg-white p-6 rounded-lg shadow-lg opacity-80 w-full max-w-xl">
                        <div class="flex flex-col space-y-4">
                            <div class="flex items-center space-x-6">
                                <label class="text-gray-700 text-left w-36">First Name </label>
                                <input type="text" name="first_name" value="{{ $user->first_name }}" class="w-48 px-3 py-2 border border-gray-300 rounded-md">
                            </div>

                            <div class="flex items-center space-x-6">
                                <label class="text-gray-700 text-left w-36">Last Name </label>
                                <input type="text" name="last_name" value="{{ $user->last_name }}" class="w-48 px-3 py-2 border border-gray-300 rounded-md">
                            </div>

                            <div class="flex items-center space-x-6">
                                <label class="text-gray-700 text-left w-36">Email </label>
                                <input type="email" name="email" value="{{ $user->email }}" class="w-48 px-3 py-2 border border-gray-300 rounded-md">
                            </div>

                            <div class="flex items-center space-x-6">
                                <label class="text-gray-700 text-left w-36">Department </label>
                                <input type="text" name="department" value="{{ $user->department }}" class="w-48 px-3 py-2 border border-gray-300 rounded-md">
                            </div>

                            <div class="flex items-center space-x-6">
                                <label class="text-gray-700 text-left w-36">Password </label>
                                <input type="password" name="password" class="w-48 px-3 py-2 border border-gray-300 rounded-md">
                            </div>

                            <div class="flex items-center space-x-6">
                                <label class="text-gray-700 text-left w-36">Confirm Password </label>
                                <input type="password" name="password_confirmation" class="w-48 px-3 py-2 border border-gray-300 rounded-md">
                            </div>

                            <div class="flex justify-center mt-6">
                                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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

        // Automatically hide success message after 3 seconds
        window.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.display = 'none'; // Hide the success message after 3 seconds
                }, 3000);
            }
        });
    </script>

    <style>
    /* Remove scrollbars from the entire page */
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden;
    }

    /* Ensure that all elements inside the container are also hidden if they exceed the size */
    .no-scrollbar {
        overflow: hidden;
    }
</style>

@endsection