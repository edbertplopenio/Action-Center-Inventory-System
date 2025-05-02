@extends('layouts.app')

@section('title', 'Records')

@section('content')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Add Google Fonts link for Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
    <!-- Include jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>


    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- Include SweetAlert Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Include SweetAlert Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




    <!-- Added scrollbar in the tbody -->
    <style>
        /* Apply font size and font family */
        body,
        #myTable {
            font-family: 'Inter', Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }

        table.dataTable thead th {
            text-align: center;
        }



        /* Table Header Styling */
        #myTable th {
            background-color: #EBF8FD;
            color: #4a5568;
            font-weight: 600;
            text-align: center;
            padding: 15px;
            border-bottom: 2px solid #e2e8f0;
        }

        /* Table Data Styling */
        #myTable td {
            background-color: #ffffff;
            color: #2d3748;
            text-align: center;
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
        }

        /* Add hover effect for rows */
        #myTable tr:hover {
            background-color: #b3eaff;
        }

        /* Scrollable tbody */
        .dataTables_scrollBody {
            max-height: 400px;
            /* Adjust height as needed */
            overflow-y: auto;
        }
    </style>


    <style>
        #userTable {
            text-align: center;
        }

        #userTable thead th {
            text-align: center;
        }

        #userTable tbody td {
            text-align: center;
        }
    </style>



    <!-- 
<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            "scrollY": "425px",  // Enable vertical scrolling with a fixed height
            "scrollCollapse": true, // Collapse height when content is less
            "scrollX": false,  // Disable horizontal scrolling
            "paging": true,    // Enable pagination (optional)
            "searching": true, // Enable search (optional)
            "ordering": true   // Enable sorting (optional)
        });
    });
</script> -->




    <!-- CSS for Pagination -->
    <style>
        /* Style the container */
        .dataTables_length {
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            color: #5ad4f5;
            /* Lighter shade of #4cc9f0 */
            margin-bottom: 6px;
            padding: 4px 8px;
            background-color: #e6f7ff;
            /* Light blue background */
            border-radius: 6px;
            border: 1px solid #b3eaff;
            /* Soft blue border */
        }

        /* Style the dropdown select */
        .dt-length select {
            padding: 4px 8px;
            border: 1px solid #b3eaff;
            /* Soft blue border */
            border-radius: 4px;
            background-color: #ffffff;
            /* White dropdown background */
            color: #4aaed4;
            /* Slightly darker text */
            font-size: 12px;
            cursor: pointer;
            outline: none;
            transition: all 0.2s ease-in-out;
        }

        /* Hover and Focus Effects */
        .dt-length select:hover {
            border-color: #87dff7;
            /* Brighter blue */
            background-color: #def3ff;
            /* Slightly darker background */
        }

        .dt-length select:focus {
            border-color: #4cc9f0;
            box-shadow: 0 0 3px rgba(76, 201, 240, 0.4);
            background-color: #c9efff;
        }

        /* Style the label */
        .dt-length label {
            font-weight: 500;
            color: rgb(0, 0, 0);
            /* Primary blue shade */
        }
    </style>


    <!-- CSS for Search Bar -->
    <style>
        /* Style the search container */
        .dt-search {
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
        }

        /* Style the search input */
        .dt-search input[type="search"] {
            padding: 4px 8px;
            border: 1px solid #b3eaff;
            /* Soft blue border */
            border-radius: 4px;
            background-color: #ffffff;
            /* White input background */
            color: #4aaed4;
            /* Slightly darker text */
            font-size: 12px;
            cursor: text;
            outline: none;
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        /* Keep only focus effect */
        .dt-search input[type="search"]:focus {
            border-color: #4cc9f0;
            box-shadow: 0 0 3px rgba(76, 201, 240, 0.4);
            background-color: #c9efff;
        }

        /* Style the label */
        .dt-search label {
            font-weight: 500;
            color: rgb(0, 0, 0);
            /* Primary blue shade */
        }
    </style>







</head>

<div class="mx-auto p-2" style="width: 1220px; height: 700px; font-family: 'Inter', sans-serif;">


    <div class="bg-white p-6 shadow-lg rounded-lg h-full">
        <!-- Title and Button inside this div -->
        <div class="flex justify-between items-center mb-1 pt-0">
            <h1 class="text-3xl text-left">User Management</h1>
            <div class="flex space-x-2 w-auto">
                <button id="openModalBtn" class="px-6 py-2 min-w-[140px] max-w-[160px] bg-[#4cc9f0] text-white border-2 border-[#4cc9f0] rounded-full hover:bg-[#3fb3d1] mb-2 text-sm">
                    Add User
                </button>
                <a href="{{ route('users.deactivated') }}">
                    <button class="px-6 py-2 min-w-[140px] max-w-[160px] bg-[#f0b84c] text-white border-2 border-[#f0b84c] rounded-full hover:bg-[#d19b3f] mb-2 text-sm">
                        Deactivated
                    </button>
                </a>

            </div>
        </div>



        <div style="height: 625px; overflow-y: auto;"> <!-- Added overflow-y-auto -->
            <table id="userTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="display:none;">ID</th> <!-- Hidden ID column -->
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Status</th> <!-- Added Status column -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr class="user-row cursor-pointer"
                        data-id="{{ $user->id }}"
                        data-first_name="{{ $user->first_name }}"
                        data-last_name="{{ $user->last_name }}"
                        data-email="{{ $user->email }}"
                        data-role="{{ $user->user_role }}"
                        data-department="{{ $user->department ?? 'N/A' }}"
                        data-profile_picture="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : '' }}"
                        data-created_at="{{ $user->created_at }}"
                        data-last_login="{{ $user->last_login ?? 'N/A' }}"
                        data-created_by="{{ $user->created_by ?? 'N/A' }}"
                        data-updated_at="{{ $user->updated_at }}">

                        <td style="display:none;">{{ $user->id }}</td> <!-- Hidden ID value -->

                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->user_role }}</td>
                        <td>{{ $user->department ?? 'N/A' }}</td>
                        <td>{{ ucfirst($user->status) }}</td>
                        <td>
                            <!-- Edit button, disabled if not the logged-in user -->
                            <button class="edit-record-btn px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] text-xs w-24"
                                data-id="{{ $user->id }}"
                                {{ $user->id !== $loggedInUserId ? 'disabled' : '' }}
                                @if($user->id !== $loggedInUserId) style="opacity: 0.5; cursor: not-allowed;" @endif> Edit
                            </button>

                            <!-- Deactivate/Activate buttons -->
                            @if($user->status === 'active')
                            <button class="deactivate-btn px-2 py-1 m-1 bg-[#f0b84c] text-white rounded hover:bg-[#d19b3f] text-xs w-24"
                                data-id="{{ $user->id }}">Deactivate</button>
                            @else
                            <button class="activate-btn px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] text-xs w-24"
                                data-id="{{ $user->id }}">Activate</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

        </div>

    </div>
</div>





<!--  Edit Modal Form  -->
<div class="relative z-10" id="editUserModal" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 transition-opacity" aria-hidden="true"></div>

    <div class="fixed inset-0 z-10 flex items-center justify-center">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full" style="max-width: 500px;">
                <div class="bg-white px-6 py-5 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Edit User</h3>

                    <!-- User Form -->
                    <form id="editUserForm">
                        @csrf
                        <input type="hidden" name="user_id" id="edit_user_id">
                        <div class="space-y-6">
                            <div class="border-b border-gray-900/10 pb-6">
                                <p class="mt-1 text-xs text-gray-600">Update the user details.</p>

                                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-1">
                                    <div class="grid grid-cols-2 gap-6">
                                        <!-- First Name -->
                                        <div>
                                            <label for="edit_first_name" class="block text-xs font-medium text-gray-900">First name</label>
                                            <input type="text" name="first_name" id="edit_first_name" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter first name">
                                        </div>

                                        <!-- Last Name -->
                                        <div>
                                            <label for="edit_last_name" class="block text-xs font-medium text-gray-900">Last name</label>
                                            <input type="text" name="last_name" id="edit_last_name" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter last name">
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="sm:col-span-1">
                                        <label for="edit_email" class="block text-xs font-medium text-gray-900">Email</label>
                                        <input type="email" name="email" id="edit_email" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter email">
                                    </div>

                                    <div class="grid grid-cols-2 gap-6">
                                        <!-- Role -->
                                        <div>
                                            <label for="edit_role" class="block text-xs font-medium text-gray-900">Role</label>
                                            <select name="role" id="edit_role" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                                <option value="Admin">Admin</option>
                                                <option value="Borrower">Borrower</option>
                                            </select>
                                        </div>

                                        <!-- Department -->
                                        <div>
                                            <label for="edit_department" class="block text-xs font-medium text-gray-900">Department</label>
                                            <input type="text" name="department" id="edit_department" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter department">
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="sm:col-span-1">
                                        <label for="edit_password" class="block text-xs font-medium text-gray-900"> New Password</label>
                                        <input type="password" name="password" id="edit_password" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter new password">
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="sm:col-span-1">
                                        <label for="edit_password_confirmation" class="block text-xs font-medium text-gray-900">Confirm Password</label>
                                        <input type="password" name="password_confirmation" id="edit_password_confirmation" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Confirm new password">
                                    </div>

                                    <div class="col-span-full">
                                        <label for="photo" class="block text-xs font-medium text-gray-900">Profile Picture</label>
                                        <div class="mt-2 grid grid-cols-2 items-center gap-x-4">
                                            <!-- Image Preview & Placeholder (Left Column) -->
                                            <div class="relative flex justify-center items-center">
                                                <!-- Placeholder Icon -->
                                                <svg id="photoPlaceholder" class="size-12 text-gray-300 absolute" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                                                </svg>

                                                <!-- Image Preview -->
                                                <img id="photoPreview" class="size-12 rounded-full hidden object-cover border border-gray-300 absolute" alt="Profile Picture Preview">
                                            </div>

                                            <!-- Upload Button (Right Column) -->
                                            <div class="flex flex-col gap-y-2">
                                                <input type="file" id="photoInput" name="photo" accept="image/png, image/jpeg, image/jpg" class="hidden">
                                                <button type="button" id="addPhotoBtn" class="rounded-md bg-white px-1.5 py-0.5 text-xs font-medium text-gray-900 ring-1 shadow-xs ring-gray-300 hover:bg-gray-50">
                                                    Add Picture
                                                </button>
                                                <p id="photoError" class="text-red-500 text-xs hidden">Invalid image format or size too large.</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-6 flex items-center justify-end gap-x-6">
                                <button type="button" class="text-xs font-semibold text-gray-900" id="closeEditUserModal">Cancel</button>
                                <button type="submit" class="rounded-md bg-blue-600 px-3 py-2 text-xs font-semibold text-white shadow-xs hover:bg-blue-500">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Edit JS -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("✅ Script Loaded");

        const editModal = document.getElementById("editUserModal");
        const closeModalButton = document.getElementById("closeEditUserModal");
        const editUserForm = document.getElementById("editUserForm");

        // Select modal form fields
        const editUserId = document.getElementById("edit_user_id");
        const editFirstName = document.getElementById("edit_first_name");
        const editLastName = document.getElementById("edit_last_name");
        const editEmail = document.getElementById("edit_email");
        const editRole = document.getElementById("edit_role");
        const editDepartment = document.getElementById("edit_department");
        const editPassword = document.getElementById("edit_password");
        const editPasswordConfirmation = document.getElementById("edit_password_confirmation");

        // Select profile picture fields
        const addPhotoBtn = document.getElementById("addPhotoBtn");
        const photoInput = document.getElementById("photoInput");
        const photoPreview = document.getElementById("photoPreview");
        const photoPlaceholder = document.getElementById("photoPlaceholder");
        const photoError = document.getElementById("photoError");

        let originalUserData = {}; // Store original data for change detection
        let photoChanged = false; // Track if a new photo is selected

        // Use event delegation to handle dynamically loaded edit buttons
        document.addEventListener("click", function(event) {
            if (event.target.classList.contains("edit-record-btn")) {
                event.stopPropagation(); // Prevent row click event from interfering

                const button = event.target;
                const row = button.closest(".user-row");

                if (!row) return;

                // Populate modal with user data
                editUserId.value = row.dataset.id;
                editFirstName.value = row.dataset.first_name || "";
                editLastName.value = row.dataset.last_name || "";
                editEmail.value = row.dataset.email || "";
                editRole.value = row.dataset.role || "Borrower";
                editDepartment.value = row.dataset.department || "";

                // Reset password fields
                editPassword.value = "";
                editPasswordConfirmation.value = "";

                // Reset profile picture input
                photoChanged = false;
                photoInput.value = "";

                // Load existing profile picture in preview
                let profilePicture = row.dataset.profile_picture || "";

                console.log("Profile Picture URL:", profilePicture); // Debugging

                if (profilePicture.trim() !== "") {
                    photoPreview.src = profilePicture;
                    photoPreview.classList.remove("hidden");
                    photoPlaceholder.classList.add("hidden");
                } else {
                    photoPreview.classList.add("hidden");
                    photoPlaceholder.classList.remove("hidden");
                }

                // Store original user data for change detection
                originalUserData = {
                    first_name: editFirstName.value,
                    last_name: editLastName.value,
                    email: editEmail.value,
                    role: editRole.value,
                    department: editDepartment.value,
                    profile_picture: profilePicture,
                    password: "",
                };

                // Show modal
                editModal.style.display = "block";
                console.log(`✏️ Editing User: ${editFirstName.value} ${editLastName.value}`);
            }
        });

        // Handle profile picture selection
        addPhotoBtn.addEventListener("click", function() {
            photoInput.click();
        });

        photoInput.addEventListener("change", function() {
            const file = photoInput.files[0];

            if (!file) return;

            // Validate file type (JPEG, PNG, JPG)
            const allowedTypes = ["image/jpeg", "image/jpg", "image/png"];
            if (!allowedTypes.includes(file.type)) {
                photoError.textContent = "Only JPG, JPEG, or PNG images are allowed.";
                photoError.classList.remove("hidden");
                photoInput.value = "";
                return;
            }

            // Validate file size (max 2MB)
            const maxSize = 2 * 1024 * 1024; // 2MB
            if (file.size > maxSize) {
                photoError.textContent = "Image size must be less than 2MB.";
                photoError.classList.remove("hidden");
                photoInput.value = "";
                return;
            }

            // Hide error message
            photoError.classList.add("hidden");
            photoChanged = true;

            // Display selected image preview
            const reader = new FileReader();
            reader.onload = function(e) {
                photoPreview.src = e.target.result;
                photoPreview.classList.remove("hidden");
                photoPlaceholder.classList.add("hidden");
            };
            reader.readAsDataURL(file);
        });

        // Handle form submission
        editUserForm.addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent default form submission

            const userId = editUserId.value;
            const formData = new FormData();
            formData.append("_method", "PUT"); // Important for Laravel updates
            formData.append("first_name", editFirstName.value.trim());
            formData.append("last_name", editLastName.value.trim());
            formData.append("email", editEmail.value.trim());
            formData.append("user_role", editRole.value);
            formData.append("department", editDepartment.value.trim());

            // Include password fields only if a new password is entered
            if (editPassword.value.length > 0) {
                formData.append("password", editPassword.value);
                formData.append("password_confirmation", editPasswordConfirmation.value);
            }

            // Include profile picture if changed
            if (photoChanged && photoInput.files.length > 0) {
                formData.append("profile_picture", photoInput.files[0]);
            }

            // **Check if data has changed**
            let isChanged = photoChanged; // If a new photo is uploaded, mark as changed
            const fieldsToCheck = ["first_name", "last_name", "email", "role", "department", "password"];

            fieldsToCheck.forEach((field) => {
                const element = document.getElementById(`edit_${field}`);
                if (element && originalUserData[field] !== element.value.trim()) {
                    isChanged = true;
                }
            });

            if (!isChanged) {
                Swal.fire({
                    icon: "info",
                    title: "No Changes Detected",
                    text: "You have not made any changes.",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "OK",
                });
                return;
            }

            // Send AJAX request
            fetch(`/admin/users/${userId}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    },
                    body: formData,
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "success") {
                        Swal.fire({
                            icon: "success",
                            title: "User Updated!",
                            text: `User ${editFirstName.value} ${editLastName.value} has been successfully updated.`,
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "OK",
                        }).then(() => {
                            editModal.style.display = "none";
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Update Failed!",
                            text: Object.values(data.errors).flat().join("\n"),
                            confirmButtonColor: "#d33",
                            confirmButtonText: "Try Again",
                        });
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    Swal.fire({
                        icon: "error",
                        title: "Oops!",
                        text: "Something went wrong. Please try again later.",
                        confirmButtonColor: "#d33",
                        confirmButtonText: "OK",
                    });
                });
        });

        // Close Modal Button
        closeModalButton.addEventListener("click", function() {
            editModal.style.display = "none";
        });
    });
</script>













<!-- Success Modal -->
<div id="successModal" class="relative z-10 hidden" aria-labelledby="success-modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:size-10">
                            <svg class="size-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-base font-semibold text-gray-900" id="success-modal-title">Success</h3>
                            <p class="text-sm text-gray-500">Record has been successfully updated.</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" id="closeSuccessModalBtn" class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-green-500 sm:w-auto">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div id="errorModal" class="relative z-10 hidden" aria-labelledby="error-modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                            <svg class="size-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-base font-semibold text-gray-900" id="error-modal-title">Error</h3>
                            <p class="text-sm text-gray-500" id="errorMessage">Something went wrong while updating the record.</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" id="closeErrorModalBtn" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:w-auto">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Activate Confirmation Modal -->
<div class="relative z-10" id="activateModal" aria-labelledby="activateModal-title" role="dialog" aria-modal="true" style="display: none;">
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-blue-100 sm:mx-0 sm:size-10">
                            <svg class="size-6 text-blue-600" id="activateModalIcon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" id="activateModalIconPath" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-base font-semibold text-gray-900" id="activateModal-title">Confirm Activation</h3>
                            <p class="text-sm text-gray-500" id="activateModal-message">Are you sure you want to activate this user? This action cannot be undone.</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-blue-500 sm:ml-3 sm:w-auto" id="confirmActivateBtn">Confirm Activate</button>
                    <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto" id="cancelActivateBtn">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Attach event listeners to all Activate buttons
        document.querySelectorAll('.activate-btn').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                console.log('Activate button clicked for User ID:', userId);

                // Show the activation confirmation modal
                document.getElementById('activateModal').style.display = 'block';

                // Set the Confirm button's data-id attribute
                document.getElementById('confirmActivateBtn').setAttribute('data-id', userId);
            });
        });

        // Handle Confirm Activate action
        document.getElementById('confirmActivateBtn').addEventListener('click', function() {
            const userId = this.getAttribute('data-id');
            console.log('Confirm activation for User ID:', userId);

            // Send AJAX request to activate the user
            fetch(`/admin/users/activate/${userId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Activation response:', data);

                    if (data.success) {
                        // Show SweetAlert success message
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Reload the page after clicking OK in SweetAlert
                            window.location.reload();
                        });
                    } else {
                        // Show SweetAlert error message
                        Swal.fire({
                            title: 'Error!',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error activating user:', error);
                    // Show SweetAlert error message
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while activating.',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                });
        });

        // Handle Cancel button (close modal without action)
        document.getElementById('cancelActivateBtn').addEventListener('click', function() {
            document.getElementById('activateModal').style.display = 'none';
            console.log('Activation canceled.');
        });
    });
</script>












<!-- Deactivate Confirmation Modal -->
<div class="relative z-10" id="deactivateModal" aria-labelledby="deactivateModal-title" role="dialog" aria-modal="true" style="display: none;">
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                            <svg class="size-6 text-red-600" id="deactivateModalIcon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" id="deactivateModalIconPath" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-base font-semibold text-gray-900" id="deactivateModal-title">Confirm Deactivation</h3>
                            <p class="text-sm text-gray-500" id="deactivateModal-message">Are you sure you want to deactivate this user? This action cannot be undone.</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto" id="confirmDeactivateBtn">Confirm Deactivate</button>
                    <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto" id="cancelDeactivateBtn">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.deactivate-btn').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                console.log('Deactivate button clicked for User ID:', userId);

                document.getElementById('deactivateModal').style.display = 'block';
                document.getElementById('confirmDeactivateBtn').setAttribute('data-id', userId);
            });
        });

        document.getElementById('confirmDeactivateBtn').addEventListener('click', function() {
            const userId = this.getAttribute('data-id');
            console.log('Confirm deactivation for User ID:', userId);

            fetch(`/admin/users/deactivate/${userId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Deactivation response:', data);

                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Close the deactivation modal
                            document.getElementById('deactivateModal').style.display = 'none';
                            setTimeout(() => {
                                window.location.reload();
                            }, 500); // Add a short delay to allow the modal to close before reloading
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        }).then(() => {
                            document.getElementById('deactivateModal').style.display = 'none';
                        });
                    }
                })
                .catch(error => {
                    console.error('Error deactivating user:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while deactivating.',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    }).then(() => {
                        document.getElementById('deactivateModal').style.display = 'none';
                    });
                });
        });

        document.getElementById('cancelDeactivateBtn').addEventListener('click', function() {
            document.getElementById('deactivateModal').style.display = 'none';
            console.log('Deactivation canceled.');
        });
    });
</script>


<script>
    function showResultModal(status, message) {
        const resultModal = document.getElementById('resultModal');
        const resultMessage = document.getElementById('resultModal-message');
        const resultTitle = document.getElementById('resultModal-title');
        const resultIcon = document.getElementById('resultModalIcon');
        const resultIconPath = document.getElementById('resultModalIconPath');

        if (status === 'success') {
            resultIcon.classList.replace('text-red-600', 'text-green-600');
            resultIconPath.setAttribute('d', 'M9 12l2 2l4 -4m-5 0a7 7 0 1 1 7 7a7 7 0 0 1 -7 -7Z'); // Success checkmark icon
            resultTitle.textContent = 'Action Successful';
            resultMessage.textContent = message;
        } else {
            resultIcon.classList.replace('text-green-600', 'text-red-600');
            resultIconPath.setAttribute('d', 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z'); // Error icon
            resultTitle.textContent = 'Action Failed';
            resultMessage.textContent = message;
        }

        // Show the modal
        resultModal.style.display = 'block';

        // Close the result modal when clicking the close button
        document.getElementById('resultModalCloseBtn').addEventListener('click', function() {
            resultModal.style.display = 'none';
        });
    }
</script>







<!-- Modal Display HTML -->
<div class="relative z-10" id="showUserModal" aria-labelledby="showUserModal-title" role="dialog" aria-modal="true" style="display: none;">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 transition-opacity" aria-hidden="true"></div>
    <div class="fixed inset-0 z-10 flex items-center justify-center">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full" style="max-width: 600px;">
                <div class="bg-white px-6 py-5 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-semibold text-gray-900" id="showUserModal-title">User Details</h3>

                    <!-- User Information -->
                    <div class="space-y-4">
                        <div class="border-b border-gray-300 pb-4">
                            <p class="mt-1 text-xs text-gray-500">Here are the details of the selected user.</p>

                            <div class="mt-4 flex items-center space-x-4">
                                <!-- Profile Picture -->
                                <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-300 flex items-center justify-center text-white text-lg font-bold">
                                    <img id="showUserImage" class="w-full h-full object-cover hidden" alt="User Image"
                                        onerror="this.style.display='none'; document.getElementById('showUserInitials').style.display='flex';" />
                                    <div id="showUserInitials" class="hidden w-full h-full flex items-center justify-center text-xs font-bold bg-gray-500"></div>
                                </div>

                                <!-- Name & Email -->
                                <div>
                                    <p class="text-sm font-bold text-gray-900 show-full-name"></p>
                                    <p class="text-xs text-gray-600 show-email"></p>
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-2 gap-x-4 gap-y-4 text-xs">
                                <div>
                                    <p class="font-semibold text-gray-800">Role:</p>
                                    <p class="text-gray-600 show-role"></p>
                                </div>

                                <div>
                                    <p class="font-semibold text-gray-800">Department:</p>
                                    <p class="text-gray-600 show-department"></p>
                                </div>

                                <!-- Removed Contact Number Section -->
                                <!-- <div>
                                    <p class="font-semibold text-gray-800">Contact Number:</p>
                                    <p class="text-gray-600 show-contact-number"></p>
                                </div> -->

                                <div>
                                    <p class="font-semibold text-gray-800">Created At:</p>
                                    <p class="text-gray-600 show-created-at"></p>
                                </div>

                                <div>
                                    <p class="font-semibold text-gray-800">Last Login:</p>
                                    <p class="text-gray-600 show-last-login"></p>
                                </div>

                                <div>
                                    <p class="font-semibold text-gray-800">Created By:</p>
                                    <p class="text-gray-600 show-created-by"></p>
                                </div>

                                <div>
                                    <p class="font-semibold text-gray-800">Updated At:</p>
                                    <p class="text-gray-600 show-updated-at"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Close Button -->
                    <div class="mt-4 flex items-center justify-end">
                        <button type="button" class="text-xs font-semibold text-gray-700" id="closeShowUserModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("✅ Script Loaded: Event listeners added");

        // Function to display modal with user details
        function updateUserModal(userData) {
            console.log("🔹 Displaying User:", userData);

            // Set user details in modal
            document.querySelector('.show-full-name').textContent = `${userData.firstName} ${userData.lastName}`;
            document.querySelector('.show-email').textContent = userData.email;
            document.querySelector('.show-role').textContent = userData.role;
            document.querySelector('.show-department').textContent = userData.department;
            // Removed contact number line
            // document.querySelector('.show-contact-number').textContent = userData.contactNumber; 
            document.querySelector('.show-created-at').textContent = userData.createdAt;
            document.querySelector('.show-last-login').textContent = userData.lastLogin;
            document.querySelector('.show-created-by').textContent = userData.createdBy;
            document.querySelector('.show-updated-at').textContent = userData.updatedAt;

            // Handle profile picture or initials
            let profileImage = document.getElementById('showUserImage');
            let initialsDiv = document.getElementById('showUserInitials');

            if (userData.profilePicture) {
                profileImage.src = userData.profilePicture;
                profileImage.style.display = "block";
                initialsDiv.style.display = "none";
            } else {
                profileImage.style.display = "none";
                initialsDiv.style.display = "flex";
                initialsDiv.textContent = `${userData.firstName.charAt(0)}${userData.lastName.charAt(0)}`.toUpperCase();
            }

            // Show modal
            document.getElementById('showUserModal').style.display = 'block';
            console.log("✔️ User Modal Opened");
        }

        // Add click event listener to each row
        document.querySelectorAll('.user-row').forEach(row => {
            row.addEventListener('click', function(event) {
                if (event.target.closest('button')) return; // Ignore clicks on buttons

                // Get user data from row attributes
                const userData = {
                    firstName: this.dataset.first_name,
                    lastName: this.dataset.last_name,
                    email: this.dataset.email,
                    role: this.dataset.role,
                    department: this.dataset.department,
                    // Removed contact number line
                    // contactNumber: this.dataset.contact_number,
                    createdAt: this.dataset.created_at,
                    lastLogin: this.dataset.last_login,
                    createdBy: this.dataset.created_by,
                    updatedAt: this.dataset.updated_at,
                    profilePicture: this.dataset.profile_picture
                };

                updateUserModal(userData);
            });
        });

        // Close Modal Button
        document.getElementById('closeShowUserModal').addEventListener('click', function() {
            document.getElementById('showUserModal').style.display = 'none';
            console.log("✔️ User Modal Closed");
        });

    });
</script>









<!-- Customed modal -->



<script>
    // Select the success/error modal elements
    const resultModal = document.getElementById("resultModal");
    const resultModalTitle = document.getElementById("resultModal-title");
    const resultModalMessage = document.getElementById("resultModal-message");
    const resultModalIcon = document.getElementById("resultModalIcon");
    const resultModalIconPath = document.getElementById("resultModalIconPath");
    const resultModalCloseBtn = document.getElementById("resultModalCloseBtn");

    // Function to show the result modal
    function showResultModal(title, message, isSuccess = true) {
        resultModalTitle.textContent = title;
        resultModalMessage.textContent = message;

        resultModal.style.display = "block";
        resultModal.style.zIndex = "50"; // Set higher z-index than myModal



        // Change the icon based on success/error
        if (isSuccess) {
            resultModalIcon.classList.remove("text-red-600", "bg-red-100");
            resultModalIcon.classList.add("text-green-600", "bg-green-100");
            resultModalIconPath.setAttribute("d", "M9 12l2 2l4 -4m-5 0a7 7 0 1 1 7 7a7 7 0 0 1 -7 -7Z"); // Success icon
        } else {
            resultModalIcon.classList.remove("text-green-600", "bg-green-100");
            resultModalIcon.classList.add("text-red-600", "bg-red-100");
            resultModalIconPath.setAttribute("d", "M6 18L18 6M6 6l12 12"); // Error icon
        }

        resultModal.style.display = "block";
    }

    // Close the modal when the close button is clicked
    resultModalCloseBtn.addEventListener("click", function() {
        resultModal.style.display = "none";
    });
</script>


<!-- Modal Form HTML -->
<div class="relative z-10" id="myModal" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 transition-opacity" aria-hidden="true"></div>

    <div class="fixed inset-0 z-10 flex items-center justify-center">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full" style="max-width: 500px;">
                <div class="bg-white px-6 py-5 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Add New User</h3>

                    <!-- User Form -->
                    <form id="userForm">
                        @csrf
                        <div class="space-y-6">
                            <div class="border-b border-gray-900/10 pb-6">
                                <p class="mt-1 text-xs text-gray-600">Fill in the user details.</p>

                                
                                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-1">
                                    <div class="grid grid-cols-2 gap-6">
                                        <!-- First Name -->
                                        <div>
                                            <label for="first_name" class="block text-xs font-medium text-gray-900">First name</label>
                                            <input type="text" name="first_name" id="first_name" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter first name">
                                        </div>

                                        <!-- Last Name -->
                                        <div>
                                            <label for="last_name" class="block text-xs font-medium text-gray-900">Last name</label>
                                            <input type="text" name="last_name" id="last_name" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter last name">
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="sm:col-span-1">
                                        <label for="email" class="block text-xs font-medium text-gray-900">Email</label>
                                        <input type="email" name="email" id="email" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter email">
                                    </div>

                                    <!-- Role -->
                                    <div class="sm:col-span-1">
                                        <label for="user_role" class="block text-xs font-medium text-gray-900">Role</label>
                                        <select name="user_role" id="user_role" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                            <option value="">-- Select Role --</option> <!-- Prevent sending an empty role -->
                                            <option value="Admin">Admin</option>
                                            <option value="Borrower">Borrower</option>
                                        </select>
                                    </div>

                                    <!-- Department -->
                                    <div class="sm:col-span-1">
                                        <label for="department" class="block text-xs font-medium text-gray-900">Department</label>
                                        <input type="text" name="department" id="department" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter department">
                                    </div>

                                           <!-- Password & Confirm Password -->
                                    <div class="grid grid-cols-2 gap-3 w-full">
                                        <!-- Password -->
                                        <div class="flex flex-col relative">
                                            <label for="password" class="block text-xs font-medium text-gray-900 mb-1">Password</label>
                                            <div class="w-52 relative">
                                                <input type="password" name="password" id="password"
                                                    class="w-full pr-8 rounded-md border border-gray-300 px-2 py-1.5 text-xs text-gray-900 shadow-sm focus:ring-2 focus:ring-red-600 focus:outline-none"
                                                    placeholder="Enter password" required>
                                                <button type="button" id="togglePassword" class="absolute top-1/2 right-2 transform -translate-y-1/2">
                                                    <i id="eyeIcon" class="ph ph-eye text-black text-lg"></i>
                                                </button>
                                            </div>
                                            <div id="passwordChecklist" class="text-xs space-y-1 w-64 mt-2">
                                                <p class="font-semibold text-red-500 mb-1">Password must contain:</p>
                                                <div id="rule-length" class="flex items-center gap-2">
                                                    <span class="check-icon text-red-500">•</span>
                                                    <span class="text-red-500">At least 8 characters</span>
                                                </div>
                                                <div id="rule-lower" class="flex items-center gap-2">
                                                    <span class="check-icon text-red-500">•</span>
                                                    <span class="text-red-500">At least 1 lowercase letter (a–z)</span>
                                                </div>
                                                <div id="rule-upper" class="flex items-center gap-2">
                                                    <span class="check-icon text-red-500">•</span>
                                                    <span class="text-red-500">At least 1 uppercase letter (A–Z)</span>
                                                </div>
                                                <div id="rule-number" class="flex items-center gap-2">
                                                    <span class="check-icon text-red-500">•</span>
                                                    <span class="text-red-500">At least 1 number (0–9)</span>
                                                </div>
                                                <div id="rule-symbol" class="flex items-center gap-2">
                                                    <span class="check-icon text-red-500">•</span>
                                                    <span class="text-red-500">At least 1 special symbol (!@#$...)</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Confirm Password -->
                                        <div class="flex flex-col relative">
                                            <label for="password_confirmation" class="block text-xs font-medium text-gray-900 mb-1">Confirm Password</label>
                                            <div class="w-52 relative">
                                                <input type="password" name="password_confirmation" id="password_confirmation"
                                                    class="w-full pr-8 rounded-md border border-gray-300 px-2 py-1.5 text-xs text-gray-900 shadow-sm focus:ring-2 focus:ring-red-600 focus:outline-none"
                                                    placeholder="Confirm password" required>
                                                <button type="button" id="toggleConfirmPassword" class="absolute top-1/2 right-2 transform -translate-y-1/2">
                                                    <i id="eyeConfirmIcon" class="ph ph-eye text-black text-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>


                            <!-- Action Buttons -->
                            <div class="mt-6 flex items-center justify-end gap-x-6">
                                <button type="button" class="text-xs font-semibold text-gray-900" id="closeUserModal">Cancel</button>
                                <button type="submit" class="rounded-md bg-blue-600 px-3 py-2 text-xs font-semibold text-white shadow-xs hover:bg-blue-500">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>





<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("✅ Script Loaded");

        // Modal related elements
        const modal = document.getElementById("myModal");
        const form = document.getElementById("userForm");
        const closeUserModal = document.getElementById("closeUserModal");
        const openModalBtn = document.getElementById("openModalBtn");

        // Table DataTable initialization
        const userTable = $('#userTable').DataTable({
            "scrollY": "425px",
            "scrollCollapse": true,
            "scrollX": false,
            "paging": true,
            "searching": true,
            "ordering": true,
            "order": [
                [0, "desc"]
            ], // Sort by hidden ID column (index 0)
            "columnDefs": [{
                    "targets": 0,
                    "visible": false
                } // Hide ID column
            ]
        });


        // Open modal when the "Add Record" button is clicked
        openModalBtn.addEventListener("click", function() {
            console.log("Opening modal...");
            modal.style.display = "block"; // Show the modal
        });

        // Close modal when "Cancel" button is clicked
        closeUserModal.addEventListener("click", function() {
            console.log("Closing modal...");
            modal.style.display = "none"; // Hide the modal
            form.reset(); // Reset form inputs
        });

        // Submit the form for adding new user
        form.addEventListener("submit", async function(event) {
            event.preventDefault();
            let isValid = true;
            let formData = new FormData(form);
            let errorMessages = [];

            // Validate required fields (removed contact_number)
            const requiredFields = ["first_name", "last_name", "email", "user_role", "department", "password", "password_confirmation"];
            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                if (input.value.trim() === "") {
                    isValid = false;
                    input.classList.add("border-red-500");
                    errorMessages.push(`${field.replace("_", " ").toUpperCase()} is required.`);
                } else {
                    input.classList.remove("border-red-500");
                }
            });

            if (document.getElementById("password").value !== document.getElementById("password_confirmation").value) {
                isValid = false;
                errorMessages.push("Passwords do not match!");
            }

            if (!isValid) {
                // Use SweetAlert to show error message
                Swal.fire({
                    title: "Validation Error",
                    html: errorMessages.join("<br>"),
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            try {
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let response = await fetch("/admin/users/store", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: formData
                });

                let result = await response.json();

                if (response.ok) {
                    // Show success notification using SweetAlert
                    Swal.fire({
                        title: "Success!",
                        text: "User added successfully!",
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        modal.style.display = "none";
                        form.reset();

                        // Add new row with ID as the first hidden column
                        userTable.row.add([
                            result.user.id, // Hidden ID column for sorting
                            `${result.user.first_name} ${result.user.last_name}`,
                            result.user.email,
                            result.user.user_role,
                            result.user.department || 'N/A',
                            result.user.status || 'N/A',
                            `<button class="edit-record-btn px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] text-xs w-24"
                 data-id="${result.user.id}">Edit</button>
         <button class="deactivate-btn px-2 py-1 m-1 bg-[#f0b84c] text-white rounded hover:bg-[#d19b3f] text-xs w-24"
                 data-id="${result.user.id}">Deactivate</button>`
                        ]).draw();

                        // Reapply sorting so new user appears at the top
                        userTable.order([0, 'desc']).draw();


                    });
                } else {
                    // Show error notification using SweetAlert
                    let serverErrors = Object.values(result.errors).flat().join("<br>");
                    Swal.fire({
                        title: "Error",
                        html: serverErrors || "Failed to add user.",
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                // Show database error notification using SweetAlert
                Swal.fire({
                    title: "Database Error",
                    text: "Failed to add user. Please try again.",
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
        // Toggle password visibility
        const togglePassword = document.getElementById("togglePassword");
        const toggleConfirm = document.getElementById("toggleConfirmPassword");
        const passwordInput = document.getElementById("password");
        const confirmInput = document.getElementById("password_confirmation");
        const eyeIcon = document.getElementById("eyeIcon");
        const eyeConfirmIcon = document.getElementById("eyeConfirmIcon");

        togglePassword.addEventListener("click", () => {
            passwordInput.type = passwordInput.type === "password" ? "text" : "password";
            eyeIcon.classList.toggle("ph-eye");
            eyeIcon.classList.toggle("ph-eye-slash");
        });

        toggleConfirm.addEventListener("click", () => {
            confirmInput.type = confirmInput.type === "password" ? "text" : "password";
            eyeConfirmIcon.classList.toggle("ph-eye");
            eyeConfirmIcon.classList.toggle("ph-eye-slash");
        });

        // Live password checklist
        passwordInput.addEventListener("input", () => {
            const val = passwordInput.value;

            const updateRule = (id, isValid) => {
                const rule = document.getElementById(id);
                const icon = rule.querySelector("span.check-icon");
                const text = rule.querySelectorAll("span")[1];

                icon.classList.toggle("text-green-500", isValid);
                icon.classList.toggle("text-red-500", !isValid);
                text.classList.toggle("text-green-500", isValid);
                text.classList.toggle("text-red-500", !isValid);
            };

            updateRule("rule-length", val.length >= 8);
            updateRule("rule-lower", /[a-z]/.test(val));
            updateRule("rule-upper", /[A-Z]/.test(val));
            updateRule("rule-number", /\d/.test(val));
            updateRule("rule-symbol", /[\W_]/.test(val));
        });
    });

</script>





@endsection




<!-- AYusin mo yung tbody scrollbar -->