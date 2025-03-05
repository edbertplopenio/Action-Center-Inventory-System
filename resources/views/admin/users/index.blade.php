@extends('layouts.app')

@section('title', 'Records')

@section('content')

<head>
    <!-- Add Google Fonts link for Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
    <!-- Include jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">



    <!-- Added scrollbar in the tbody -->
    <style>
        /* Apply font size and font family */
        body,
        #myTable {
            font-family: 'Inter', Arial, sans-serif;
            font-size: 12px;
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
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                scrollY: '400px', // Enable vertical scrolling
                scrollCollapse: true,
            });
        });
    </script>



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
        .dt-length {
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


    <!-- CSS for the highlight of table when clicked -->
    <style>
        /* Styling for highlighting */
        .highlighted {
            background-color: #EBF8FD !important;
            /* Light yellow highlight */
        }
    </style>

    <script>
        $(document).ready(function() {
            var table = $('#myTable').DataTable(); // Initialize DataTables

            $('#myTable thead th').on('click', function() {
                var columnIndex = $(this).index(); // Get clicked column index

                // Remove previous highlights
                $('#myTable thead th, #myTable tbody td').removeClass('highlighted');

                // Highlight the clicked header
                $(this).addClass('highlighted');

                // Highlight all cells in the same column
                $('#myTable tbody tr').each(function() {
                    $(this).find('td').eq(columnIndex).addClass('highlighted');
                });
            });
        });
    </script>



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
                </a>

            </div>
        </div>


        <!-- Table for displaying users -->
        <div style="height: 600px; overflow-y: auto;"> <!-- Added overflow-y-auto -->
            <table id="myTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Department</th>
                        <th>Cellphone Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John Doe</td>
                        <td>johndoe@example.com</td>
                        <td>Admin</td>
                        <td>Active</td>
                        <td>IT Department</td>
                        <td>09123456789</td>
                        <td>
                            <!-- Edit Button -->
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24">
                                Edit
                            </button>

                            <!-- Deactivate/Activate Button -->
                            <button class="px-2 py-1 m-1 bg-[#f0b84c] text-white rounded hover:bg-[#d19b3f] focus:outline-none focus:ring-2 focus:ring-[#f0b84c] text-xs w-24">
                                Deactivate
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Jane Smith</td>
                        <td>janesmith@example.com</td>
                        <td>Borrower</td>
                        <td>Inactive</td>
                        <td>Library Services</td>
                        <td>09234567890</td>
                        <td>
                            <!-- Edit Button -->
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24">
                                Edit
                            </button>

                            <!-- Activate Button -->
                            <button class="px-2 py-1 m-1 bg-[#57cc99] text-white rounded hover:bg-[#45a17e] focus:outline-none focus:ring-2 focus:ring-[#57cc99] text-xs w-24">
                                Activate
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


    </div>
</div>

<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable(); // Initialize DataTable
    });
</script>






<!-- Modal Form HTML -->
<div class="relative z-10" id="myModal" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-500/75 backdrop-blur-lg transition-opacity" aria-hidden="true"></div>

    <div class="fixed inset-0 z-10 flex items-center justify-center">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full" style="max-width: 500px;">
                <div class="bg-white px-6 py-5 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Add New User</h3>

                    <!-- User Form -->
                    <form id="userForm">
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
                                        <label for="role" class="block text-xs font-medium text-gray-900">Role</label>
                                        <select name="role" id="role" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                            <option value="Admin">Admin</option>
                                            <option value="Borrower">Borrower</option>
                                        </select>
                                    </div>

                                    <!-- Status -->
                                    <div class="sm:col-span-1">
                                        <label for="status" class="block text-xs font-medium text-gray-900">Status</label>
                                        <select name="status" id="status" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>

                                    <!-- Department -->
                                    <div class="sm:col-span-1">
                                        <label for="department" class="block text-xs font-medium text-gray-900">Department</label>
                                        <input type="text" name="department" id="department" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter department">
                                    </div>

                                    <!-- Cellphone Number -->
                                    <div class="sm:col-span-1">
                                        <label for="cellphone_number" class="block text-xs font-medium text-gray-900">Cellphone Number</label>
                                        <input type="text" name="cellphone_number" id="cellphone_number" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter cellphone number">
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

<!-- Include SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById("myModal");
        const form = document.getElementById("userForm");
        const requiredFields = ["name", "email", "role", "status", "department", "cellphone_number"];

        // Open Modal
        document.getElementById("openModalBtn").addEventListener("click", function() {
            modal.style.display = "block";
        });

        // Close Modal
        document.getElementById("closeUserModal").addEventListener("click", function() {
            modal.style.display = "none";
        });

        // Close Modal When Clicking Outside
        document.querySelector(".fixed.inset-0").addEventListener("click", function(event) {
            if (!event.target.closest(".relative.transform")) {
                modal.style.display = "none";
            }
        });

        // Form Submission with Validation
        form.addEventListener("submit", async function(event) {
            event.preventDefault();
            let isValid = true;
            let formData = {};

            // Validate Required Fields
            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                if (input.value.trim() === "") {
                    isValid = false;
                    input.classList.add("border-red-500");
                } else {
                    input.classList.remove("border-red-500");
                    formData[field] = input.value.trim();
                }
            });

            if (!isValid) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Please fill in all required fields!",
                    confirmButtonColor: "#d33"
                });
                return;
            }

            console.log("Form Data Ready for Submission:", formData);

            try {
                // Simulated API request
                let response = await fetch("/submit-user", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(formData)
                });

                let result = await response.json();

                if (response.ok) {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: "User added successfully!",
                        showConfirmButton: false,
                        timer: 2000
                    });

                    // Close modal and reset form
                    setTimeout(() => {
                        modal.style.display = "none";
                        form.reset();
                    }, 1500);
                } else {
                    throw new Error(result.message || "Failed to add user.");
                }
            } catch (error) {
                Swal.fire({
                    icon: "error",
                    title: "Database Error",
                    text: "Failed to add user. Check console for details.",
                    confirmButtonColor: "#d33"
                });
                console.error("Database Error:", error.message);
            }
        });

        // Remove red border when typing
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