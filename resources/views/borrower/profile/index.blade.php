@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<!-- Include Font Awesome for the Pen Icon -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<!-- Background Image -->
<img class="absolute w-full h-full object-cover" src="{{ asset('images/bgp.png') }}" alt="Background Image" style="z-index: -1;" />

<!-- Content Form Section -->
<div class="flex justify-between items-center h-full px-24">
    <div class="mx-auto p-2 overflow-hidden" style="max-width: 1220px; max-height: 700px; font-family: 'Inter', sans-serif;">
        <div class="container mx-auto py-6">

            @if(session('success'))
                <div id="success-message" class="bg-green-500 text-white p-2 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="grid grid-cols-2 gap-12 items-start">
    @csrf

                <!-- Profile Image Section (Left Side) -->
                <div class="flex flex-col items-center justify-center h-full">
                    <div class="w-80 h-80 rounded-full border border-white flex items-center justify-center mb-6 relative">
                    <img id="profile-image-display" 
                    src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default_profile.jpg') }}" 
                    alt="Profile Image" 
                    class="w-80 h-80 rounded-full object-cover border-4 border-white" />

                        <button type="button" class="absolute bottom-2 right-2 text-white border border-white rounded-full p-2 bg-blue-600 hover:bg-blue-700" onclick="document.getElementById('profile-image').click();">
                            <i class="fas fa-pen"></i>
                        </button>
                    </div>
                    <input type="file" id="profile-image" name="profile_image" class="hidden" onchange="handleProfileImageSelect()" />
                </div>


                <!-- Form Fields (Right Side) -->
                <div class="bg-white p-6 rounded-lg shadow-lg opacity-80 w-full max-w-xl">
                    <div class="flex flex-col space-y-4">
                        <div class="flex items-center space-x-6">
                            <label class="text-gray-700 text-left w-36">First Name</label>
                            <input type="text" name="first_name" value="{{ $user->first_name }}" class="w-48 px-3 py-2 border border-gray-300 rounded-md">
                        </div>

                        <div class="flex items-center space-x-6">
                            <label class="text-gray-700 text-left w-36">Last Name</label>
                            <input type="text" name="last_name" value="{{ $user->last_name }}" class="w-48 px-3 py-2 border border-gray-300 rounded-md">
                        </div>

                        <div class="flex items-center space-x-6">
                            <label class="text-gray-700 text-left w-36">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="w-48 px-3 py-2 border border-gray-300 rounded-md">
                        </div>

                        <div class="flex items-center space-x-6">
                            <label class="text-gray-700 text-left w-36">Department</label>
                            <input type="text" name="department" value="{{ $user->department }}" class="w-48 px-3 py-2 border border-gray-300 rounded-md">
                        </div>

                        <!-- Password & Confirm Password Section -->
                        <div class="grid grid-cols-2 gap-6 w-full">
                            <!-- Password -->
                            <div class="flex flex-col relative">
                                <label for="password" class="text-gray-700 text-left mb-2">Password</label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" class="w-full pr-10 px-3 py-2 border border-gray-300 rounded-md">
                                    <button type="button" id="togglePassword" class="absolute top-1/2 right-3 transform -translate-y-1/2">
                                        <i id="eyeIcon" class="fas fa-eye text-gray-600"></i>
                                    </button>
                                </div>

                                <!-- Password Checklist -->
                                <div id="passwordChecklist" class="text-xs space-y-1 mt-2">
                                    <p class="font-semibold text-gray-700 mb-1">Password must contain:</p>
                                    <div id="rule-length" class="flex items-center gap-2"><span>•</span> At least 8 characters</div>
                                    <div id="rule-lower" class="flex items-center gap-2"><span>•</span> One lowercase letter (a–z)</div>
                                    <div id="rule-upper" class="flex items-center gap-2"><span>•</span> One uppercase letter (A–Z)</div>
                                    <div id="rule-number" class="flex items-center gap-2"><span>•</span> One number (0–9)</div>
                                    <div id="rule-symbol" class="flex items-center gap-2"><span>•</span> One special symbol (!@#$...)</div>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="flex flex-col relative">
                                <label for="password_confirmation" class="text-gray-700 text-left mb-2">Confirm Password</label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full pr-10 px-3 py-2 border border-gray-300 rounded-md">
                                    <button type="button" id="toggleConfirmPassword" class="absolute top-1/2 right-3 transform -translate-y-1/2">
                                        <i id="eyeConfirmIcon" class="fas fa-eye text-gray-600"></i>
                                    </button>
                                </div>
                            </div>
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

<!-- JavaScript Section -->
<script>
    // Handle Profile Image Selection
    function handleProfileImageSelect() {
        const fileInput = document.getElementById('profile-image');
        const file = fileInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('profile-image-display').src = event.target.result;
            }
            reader.readAsDataURL(file);
        }
    }

    // Toggle Password Visibility
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password_confirmation');
        const icon = document.getElementById('eyeConfirmIcon');
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    // Password Checklist Update
    const passwordInput = document.getElementById('password');
    passwordInput.addEventListener('input', function() {
        const value = passwordInput.value;
        document.getElementById('rule-length').style.color = value.length >= 8 ? 'green' : 'red';
        document.getElementById('rule-lower').style.color = /[a-z]/.test(value) ? 'green' : 'red';
        document.getElementById('rule-upper').style.color = /[A-Z]/.test(value) ? 'green' : 'red';
        document.getElementById('rule-number').style.color = /\d/.test(value) ? 'green' : 'red';
        document.getElementById('rule-symbol').style.color = /[^A-Za-z0-9]/.test(value) ? 'green' : 'red';
    });

    // Auto-hide success message
    window.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(() => successMessage.style.display = 'none', 3000);
        }
    });
</script>

<!-- Small Styles -->
<style>
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden;
    }
    .no-scrollbar {
        overflow: hidden;
    }
</style>

@endsection
