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
    <!-- Include SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

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




    <!-- <script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "scrollY": false,  // Disable vertical scrolling
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
            <h1 class="text-3xl text-left">Records and Appraisal</h1>
            <div class="flex space-x-2 w-auto">
                <button id="openModalBtn" class="px-6 py-2 min-w-[140px] max-w-[160px] bg-[#4cc9f0] text-white border-2 border-[#4cc9f0] rounded-full hover:bg-[#3fb3d1] mb-2 text-sm">
                    Add Record
                </button>
                <a href="{{ route('records.archive') }}">
                    <button class="px-6 py-2 min-w-[140px] max-w-[160px] bg-[#f0b84c] text-white border-2 border-[#f0b84c] rounded-full hover:bg-[#d19b3f] mb-2 text-sm">
                        Deactivated
                    </button>
                </a>

            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#myTable').DataTable(); // Initialize DataTable
            });
        </script>


        <div style="height: 600px; overflow-y: auto;">
            <table id="userTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Cellphone Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->user_role }}</td>
                        <td>{{ $user->department ?? 'N/A' }}</td>
                        <td>{{ $user->contact_number ?? 'N/A' }}</td>
                        <td>
                            <button class="edit-record-btn px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] text-xs w-24"
                                data-id="{{ $user->id }}"
                                data-first_name="{{ $user->first_name }}"
                                data-last_name="{{ $user->last_name }}"
                                data-email="{{ $user->email }}"
                                data-role="{{ $user->user_role }}"
                                data-department="{{ $user->department ?? '' }}"
                                data-contact_number="{{ $user->contact_number ?? '' }}"
                                data-profile_picture="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : '' }}">
                                Edit
                            </button>

                            <button class="px-2 py-1 m-1 bg-[#f0b84c] text-white rounded hover:bg-[#d19b3f] text-xs w-24">Deactivate</button>
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


                                    <!-- Cellphone Number -->
                                    <div class="sm:col-span-1">
                                        <label for="edit_contact_number" class="block text-xs font-medium text-gray-900">Cellphone Number</label>
                                        <input type="text" name="contact_number" id="edit_contact_number" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter cellphone number">
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




<script>


</script>


<!-- Edit JS -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const editButtons = document.querySelectorAll(".edit-record-btn");
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
        const editContactNumber = document.getElementById("edit_contact_number");
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

        // Open modal and load user data
        editButtons.forEach((button) => {
            button.addEventListener("click", function() {
                const userId = this.getAttribute("data-id");
                editUserId.value = userId;
                editFirstName.value = this.getAttribute("data-first_name") || "";
                editLastName.value = this.getAttribute("data-last_name") || "";
                editEmail.value = this.getAttribute("data-email") || "";
                editRole.value = this.getAttribute("data-role") || "Borrower";
                editDepartment.value = this.getAttribute("data-department") || "";
                editContactNumber.value = this.getAttribute("data-contact_number") || "";

                // Reset password fields
                editPassword.value = "";
                editPasswordConfirmation.value = "";

                // Reset profile picture input
                photoChanged = false;
                photoInput.value = "";

                // Load existing profile picture in preview
                let profilePicture = this.getAttribute("data-profile_picture") || "";

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
                    contact_number: editContactNumber.value,
                    profile_picture: profilePicture,
                    password: "",
                };

                // Show modal
                editModal.style.display = "block";
            });
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
            formData.append("contact_number", editContactNumber.value.trim());

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
            const fieldsToCheck = ["first_name", "last_name", "email", "role", "department", "contact_number", "password"];


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
                    body: formData, // Send FormData to include file uploads
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
                    } else if (data.status === "error") {
                        let errorMessages = Object.values(data.errors)
                            .flat()
                            .join("\n");
                        Swal.fire({
                            icon: "error",
                            title: "Update Failed!",
                            text: errorMessages,
                            confirmButtonColor: "#d33",
                            confirmButtonText: "Try Again",
                        });
                    }
                })
                .catch((error) => {
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

















<!-- Archive Modal -->
<div class="relative z-10" id="archiveModal" aria-labelledby="archiveModal-title" role="dialog" aria-modal="true" style="display: none;">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <!-- Modal Panel -->
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                            <!-- Icon for error or success -->
                            <svg class="size-6 text-red-600" id="archiveModalIcon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" id="archiveModalIconPath" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-base font-semibold text-gray-900" id="archiveModal-title">Confirm Archive</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" id="archiveModal-message">Are you sure you want to archive this record? This action can be undone later.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto" id="confirmArchiveBtn">Confirm Archive</button>
                    <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto" id="cancelArchiveBtn">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Modal -->
<div class="relative z-10" id="resultModal" aria-labelledby="resultModal-title" role="dialog" aria-modal="true" style="display: none;">
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <!-- Modal Panel -->
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:size-10">
                            <!-- Success Icon -->
                            <svg class="size-6 text-green-600" id="resultModalIcon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" id="resultModalIconPath" d="M9 12l2 2l4 -4m-5 0a7 7 0 1 1 7 7a7 7 0 0 1 -7 -7Z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-base font-semibold text-gray-900" id="resultModal-title">Action Successful</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" id="resultModal-message">The record has been successfully archived!</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-green-500 sm:ml-3 sm:w-auto" id="resultModalCloseBtn">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listener for the "Confirm Archive" button only once
        document.getElementById('confirmArchiveBtn').addEventListener('click', function() {
            const recordId = this.getAttribute('data-id');
            console.log('Confirm archive clicked for record ID:', recordId);

            // Show success modal immediately after confirm
            showResultModal('success', 'The record is being archived...');

            // Perform the archive action (AJAX call or form submission)
            archiveRecord(recordId);

            // Close the modal after the action
            document.getElementById('archiveModal').style.display = 'none';
            console.log('Modal closed after archiving');
        });

        // Loop through all Archive buttons and add event listeners
        document.querySelectorAll('[id^="archiveBtn"]').forEach(button => {
            button.addEventListener('click', function() {
                // Get the record ID from the data-id attribute
                const recordId = this.getAttribute('data-id');
                console.log('Record ID:', recordId); // Log the record ID

                // Show the archive modal
                document.getElementById('archiveModal').style.display = 'block';
                console.log('Modal should now be displayed');

                // Set the data-id of the Confirm Archive button to the current recordId
                document.getElementById('confirmArchiveBtn').setAttribute('data-id', recordId);
            });
        });

        // Close the modal if the cancel button is clicked
        document.getElementById('cancelArchiveBtn').addEventListener('click', function() {
            document.getElementById('archiveModal').style.display = 'none';
            console.log('Modal closed without archiving');
        });
    });

    // Function to archive the record
    function archiveRecord(recordId) {
        // Log to check if the function is being called
        console.log('Archiving record with ID:', recordId);

        // Example of an AJAX request to archive the record
        fetch(`/admin/records/archive/${recordId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    id: recordId
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Archive response:', data); // Log the response from the server
                // Show success modal
                showResultModal('success', 'The record has been successfully archived!');

                // Remove the row from the table after successful archiving
                removeArchivedRow(recordId);
            })
            .catch(error => {
                console.error('Error archiving record:', error); // Log any errors
                // Show error modal
                showResultModal('error', 'Failed to archive the record. Please try again.');
            });
    }

    // Function to remove the row from the table after archiving
    function removeArchivedRow(recordId) {
        // Find the row in the table based on the record ID
        const row = document.querySelector(`.record-row[data-id="${recordId}"]`);

        // If the row exists, remove it
        if (row) {
            row.remove();
            console.log(`Record with ID ${recordId} has been removed from the table.`);
        }
    }

    // Function to show the result modal (success or error)
    function showResultModal(status, message) {
        // Hide the archive modal if visible
        document.getElementById('archiveModal').style.display = 'none';

        // Set content for the result modal
        const resultModal = document.getElementById('resultModal');
        const resultMessage = document.getElementById('resultModal-message');
        const resultTitle = document.getElementById('resultModal-title');
        const resultIcon = document.getElementById('resultModalIcon');
        const resultIconPath = document.getElementById('resultModalIconPath');

        if (status === 'success') {
            resultIcon.classList.replace('text-red-600', 'text-green-600');
            resultIconPath.setAttribute('d', 'M9 12l2 2l4 -4m-5 0a7 7 0 1 1 7 7a7 7 0 0 1 -7 -7Z');
            resultTitle.textContent = 'Action Successful';
            resultMessage.textContent = message;
        } else {
            resultIcon.classList.replace('text-green-600', 'text-red-600');
            resultIconPath.setAttribute('d', 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z');
            resultTitle.textContent = 'Action Failed';
            resultMessage.textContent = message;
        }

        // Show the result modal immediately
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

                                <div>
                                    <p class="font-semibold text-gray-800">Contact Number:</p>
                                    <p class="text-gray-600 show-contact-number"></p>
                                </div>

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

                                    <!-- Cellphone Number -->
                                    <div class="sm:col-span-1">
                                        <label for="contact_number" class="block text-xs font-medium text-gray-900">Cellphone Number</label>
                                        <input type="text" name="contact_number" id="contact_number" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter cellphone number">
                                    </div>

                                    <!-- Password -->
                                    <div class="sm:col-span-1">
                                        <label for="password" class="block text-xs font-medium text-gray-900">Password</label>
                                        <input type="password" name="password" id="password" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter password">
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="sm:col-span-1">
                                        <label for="confirm_password" class="block text-xs font-medium text-gray-900">Confirm Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Confirm password">
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



<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("✅ DOM fully loaded and parsed");

        const modal = document.getElementById("myModal");
        const form = document.getElementById("userForm");
        const userTable = $('#userTable').DataTable();
        const requiredFields = ["first_name", "last_name", "email", "user_role", "department", "contact_number", "password", "password_confirmation"];

        // Select the custom result modal elements
        const resultModal = document.getElementById("resultModal");
        const resultModalTitle = document.getElementById("resultModal-title");
        const resultModalMessage = document.getElementById("resultModal-message");
        const resultModalIcon = document.getElementById("resultModalIcon");
        const resultModalIconPath = document.getElementById("resultModalIconPath");
        const resultModalCloseBtn = document.getElementById("resultModalCloseBtn");

        // Function to show the result modal
        function showResultModal(title, message, isSuccess = true) {
            resultModalTitle.textContent = title;
            resultModalMessage.innerHTML = message;
            resultModal.style.display = "block";
            resultModal.style.zIndex = "50";

            // Change the icon based on success/error
            if (isSuccess) {
                resultModalIcon.classList.remove("text-red-600", "bg-red-100");
                resultModalIcon.classList.add("text-green-600", "bg-green-100");
                resultModalIconPath.setAttribute("d", "M9 12l2 2l4 -4m-5 0a7 7 0 1 1 7 7a7 7 0 0 1 -7 -7Z");
            } else {
                resultModalIcon.classList.remove("text-green-600", "bg-green-100");
                resultModalIcon.classList.add("text-red-600", "bg-red-100");
                resultModalIconPath.setAttribute("d", "M6 18L18 6M6 6l12 12");
            }
        }

        resultModalCloseBtn.addEventListener("click", function() {
            resultModal.style.display = "none";
        });

        document.getElementById("openModalBtn").addEventListener("click", function() {
            modal.style.display = "block";
        });

        document.getElementById("closeUserModal").addEventListener("click", function() {
            modal.style.display = "none";
            form.reset();
        });

        form.addEventListener("submit", async function(event) {
            event.preventDefault();
            let isValid = true;
            let formData = new FormData(form);
            let errorMessages = [];

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
                showResultModal("Validation Error", errorMessages.join("<br>"), false);
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
                    showResultModal("Success!", "User added successfully!", true);
                    setTimeout(() => {
                        modal.style.display = "none";
                        form.reset();
                    }, 1500);

                    userTable.row.add([
                        `${result.user.first_name} ${result.user.last_name}`,
                        result.user.email,
                        result.user.user_role,
                        result.user.department || 'N/A',
                        result.user.contact_number || 'N/A',
                        `<button class="edit-record-btn px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] text-xs w-24">Edit</button>
                     <button class="px-2 py-1 m-1 bg-[#f0b84c] text-white rounded hover:bg-[#d19b3f] text-xs w-24">Deactivate</button>`
                    ]).draw(false);
                } else {
                    let serverErrors = Object.values(result.errors).flat().join("<br>");
                    showResultModal("Error", serverErrors || "Failed to add user.", false);
                }
            } catch (error) {
                showResultModal("Database Error", "Failed to add user. Please try again.", false);
            }
        });

        requiredFields.forEach(field => {
            const input = document.getElementById(field);
            input.addEventListener("input", function() {
                if (input.value.trim() !== "") {
                    input.classList.remove("border-red-500");
                }
            });
        });
    });
</script>



@endsection




<!-- AYusin mo yung tbody scrollbar -->