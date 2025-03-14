@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-4xl p-5 bg-white rounded-lg shadow-lg">
    <!-- Account Information Section -->
    <h2 class="text-3xl font-semibold mb-5">Account Information</h2>
    <div class="flex flex-col sm:flex-row sm:space-x-5">
        <!-- Profile Image Section -->
        <div class="flex justify-center sm:justify-start mb-5 sm:mb-0 sm:w-1/3">
            <div class="relative">
                <!-- Display the profile image -->
                <img class="h-32 w-32 rounded-full border-2 border-gray-300 object-cover" src="https://via.placeholder.com/150" alt="Profile Image">
                
                <!-- File input for profile image upload -->
                <input type="file" id="profile_picture" name="profile_picture" class="absolute bottom-0 right-0 bg-blue-500 text-white rounded-full p-2 text-xs opacity-0 cursor-pointer z-20" />
            </div>
        </div>

        <!-- Form Section -->
        <div class="sm:w-2/3">
            <form>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-600">First Name</label>
                        <input type="text" id="first_name" name="first_name" value="Jane" class="mt-1 p-2 w-full border border-gray-300 rounded-md" />
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-600">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="Coop" class="mt-1 p-2 w-full border border-gray-300 rounded-md" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                        <div class="flex items-center space-x-2">
                            <input type="email" id="email" name="email" value="jane234@example.com" class="mt-1 p-2 w-full border border-gray-300 rounded-md" />
                            <span class="text-green-500">Verified</span>
                        </div>
                    </div>

                    <div>
                        <label for="contact_number" class="block text-sm font-medium text-gray-600">Contact Number</label>
                        <div class="flex items-center space-x-2">
                            <input type="tel" id="contact_number" name="contact_number" value="(209) 555-0104" class="mt-1 p-2 w-full border border-gray-300 rounded-md" />
                            <span class="text-green-500">Verified</span>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" class="mt-1 p-2 w-full border border-gray-300 rounded-md" />
                    </div>

                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-600">Country</label>
                        <select id="country" name="country" class="mt-1 p-2 w-full border border-gray-300 rounded-md">
                            <option value="Bangladesh">Bangladesh</option>
                            <!-- Add other countries as needed -->
                        </select>
                    </div>
                </div>

                <!-- Buttons Section -->
                <div class="mt-4 flex justify-end space-x-4">
                    <!-- Save Button (Initially Hidden) -->
                    <button
                        type="submit"
                        class="save-record-btn px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24 opacity-0 cursor-not-allowed transition-opacity duration-200"
                        id="saveButton">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Get all form fields
    const formFields = document.querySelectorAll('input, select');
    const saveButton = document.getElementById('saveButton');

    // Listen for changes on form fields
    formFields.forEach(field => {
        field.addEventListener('input', () => {
            // Show the "Save" button when the user edits the info
            saveButton.classList.remove('opacity-0');
            saveButton.classList.remove('cursor-not-allowed');
            saveButton.classList.add('opacity-100');
            saveButton.classList.add('cursor-pointer');
        });
    });
</script>

@endsection
