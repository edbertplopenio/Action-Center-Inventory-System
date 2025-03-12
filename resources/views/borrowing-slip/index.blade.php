@extends('layouts.app')

@section('title', 'Borrowing Slip')

@section('content')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Added scrollbar in the tbody -->
    <style>
    /* Apply font size and font family */
    body,
    #myTable {
        font-family: 'Inter', Arial, sans-serif;
        font-size: 16px; /* Increased for larger readability */
        margin: 0;
        padding: 0;
    }

    table.dataTable thead th {
        text-align: center;
        font-size: 18px; /* Increased font size for header */
    }

    /* Table Header Styling */
    #myTable th {
        background-color: #EBF8FD;
        color: #4a5568;
        font-weight: 600;
        text-align: center;
        padding: 14px; /* Increased padding */
        border-bottom: 2px solid #e2e8f0;
    }

    /* Table Data Styling */
    #myTable td {
        background-color: #ffffff;
        color: #2d3748;
        text-align: center;
        padding: 12px; /* Increased padding for better spacing */
        font-size: 16px; /* Increased font size for better readability */
        border-bottom: 1px solid #e2e8f0;
    }

    /* Add hover effect for rows */
    #myTable tr:hover {
        background-color: #b3eaff;
    }

    /* Table container to make it scrollable */
    .table-container {
        max-height: 550px; /* Adjust the height */
        max-width: 100%; /* Make it responsive */
        overflow-y: auto; /* Enables vertical scrolling */
    }

    /* Button Styling */
    .btn {
        font-size: 16px; /* Increased button text for more visibility */
        padding: 12px 20px; /* Adjusted button padding */
    }
</style>

<!-- CSS for Pagination -->
<style>
    /* Style the container */
    .dataTables_length {
        display: flex;
        align-items: center;
        gap: 6px;
        font-family: 'Inter', sans-serif;
        font-size: 16px; /* Increased font size for pagination */
        color: #5ad4f5;
        margin-bottom: 6px;
        padding: 8px 16px; /* Increased padding */
        background-color: #e6f7ff;
        border-radius: 6px;
        border: 1px solid #b3eaff;
    }

    .dt-length select {
        padding: 8px 14px; /* Increased padding */
        font-size: 16px; /* Increased font size */
        border: 1px solid #b3eaff;
        border-radius: 4px;
        background-color: #ffffff;
        color: #4aaed4;
        cursor: pointer;
        outline: none;
        transition: all 0.2s ease-in-out;
    }

    .dt-length select:focus {
        border-color: #4cc9f0;
        background-color: #c9efff;
    }
</style>

<!-- CSS for Search Bar -->
<style>
    .dt-search {
        display: flex;
        align-items: center;
        gap: 6px;
        font-family: 'Inter', sans-serif;
        font-size: 16px; /* Increased font size for search bar */
    }

    .dt-search input[type="search"] {
        padding: 8px 16px; /* Increased padding */
        font-size: 16px; /* Increased font size for search bar */
        border: 1px solid #b3eaff;
        border-radius: 4px;
        background-color: #ffffff;
        color: #4aaed4;
        cursor: text;
        outline: none;
        transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .dt-search input[type="search"]:focus {
        border-color: #4cc9f0;
        background-color: #c9efff;
    }
</style>
</head>

<!-- Borrowing Slip Table -->
<div class="container mx-auto p-6">
    <div class="bg-white p-6 shadow-lg rounded-lg h-full">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold text-gray-800">Borrowing Slips</h1>
            <button id="openModalBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none transition duration-300">Create Borrowing Slip</button>
        </div>

        <!-- Borrowing Slips Table -->
        <div class="table-container overflow-x-auto">
            <table id="borrowingSlipTable" class="min-w-full bg-white shadow-md rounded-lg border-collapse">
                <thead class="bg-indigo-600 text-white">
                    <tr>
                        <th class="px-6 py-2 text-left">Responsible Person</th>
                        <th class="px-6 py-2 text-left">Item Code</th>
                        <th class="px-6 py-2 text-left">Borrow Date</th>
                        <th class="px-6 py-2 text-left">Quantity</th>
                        <th class="px-6 py-2 text-left">Due Date</th>
                        <th class="px-6 py-2 text-left">Signature</th>
                        <th class="px-6 py-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($borrowingSlips as $slip)
                    <tr class="border-b" id="row_{{ $slip->id }}">
                        <td class="px-6 py-3">{{ $slip->responsible_person }}</td>
                        <td class="px-6 py-3">{{ $slip->item_code }}</td>
                        <td class="px-6 py-3">{{ \Carbon\Carbon::parse($slip->borrow_date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-3">{{ $slip->quantity }}</td>
                        <td class="px-6 py-3">{{ \Carbon\Carbon::parse($slip->due_date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-3">
                            @if($slip->signature)
                                <img src="{{ Storage::url($slip->signature) }}" alt="Signature" class="w-12 h-12 object-cover"> 
                            @else
                                No Signature
                            @endif
                        </td>
                        <td class="px-6 py-3">
                            <div class="flex space-x-4">
                                <button class="editBtn bg-blue-600 text-white rounded px-4 py-2" data-id="{{ $slip->id }}">Edit</button>
                                <button class="deleteBtn bg-red-600 text-white rounded px-4 py-2" data-id="{{ $slip->id }}">Delete</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Create Borrowing Slip Modal -->
<div id="createBorrowingSlipModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Borrowing Slip</h2>
        <form method="POST" action="{{ route('borrowing-slip.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-2 gap-6 mb-4"> <!-- Adjusted spacing between the fields -->

                <!-- Name Input -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" class="form-input mt-1 block w-full text-sm p-2 border border-gray-300 rounded-md" required>
                </div>

                <!-- Department Input -->
                <div class="mb-4">
                    <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                    <input type="text" name="department" id="department" class="form-input mt-1 block w-full text-sm p-2 border border-gray-300 rounded-md" required>
                </div>

                <!-- Email Input -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="form-input mt-1 block w-full text-sm p-2 border border-gray-300 rounded-md" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Please enter a valid email address">
                </div>

                <!-- Responsible Person Input -->
                <div class="mb-4">
                    <label for="responsible_person" class="block text-sm font-medium text-gray-700">Responsible Person</label>
                    <input type="text" name="responsible_person" id="responsible_person" class="form-input mt-1 block w-full text-sm p-2 border border-gray-300 rounded-md" required>
                </div>

                <!-- Item Code Input -->
                <div class="mb-4">
                    <label for="item_code" class="block text-sm font-medium text-gray-700">Item Code</label>
                    <input type="text" name="item_code" id="item_code" class="form-input mt-1 block w-full text-sm p-2 border border-gray-300 rounded-md" required>
                </div>

                <!-- Borrow Date Input -->
                <div class="mb-4">
                    <label for="borrow_date" class="block text-sm font-medium text-gray-700">Borrow Date</label>
                    <input type="date" name="borrow_date" id="borrow_date" class="form-input mt-1 block w-full text-sm p-2 border border-gray-300 rounded-md" required>
                </div>

                <!-- Quantity Input -->
                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-input mt-1 block w-full text-sm p-2 border border-gray-300 rounded-md" required>
                </div>

                <!-- Due Date Input -->
                <div class="mb-4">
                    <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                    <input type="date" name="due_date" id="due_date" class="form-input mt-1 block w-full text-sm p-2 border border-gray-300 rounded-md" required>
                </div>

                <!-- Signature File Input -->
                <div class="mb-4">
                    <label for="signature" class="block text-sm font-medium text-gray-700">Signature</label>
                    <input type="file" name="signature" id="signature" class="form-input mt-1 block w-full text-sm p-2 border border-gray-300 rounded-md" accept="image/*" required>
                </div>

            </div>

            <!-- Submit and Cancel Buttons -->
            <div class="flex justify-between mt-6">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none text-sm w-32">Submit</button>
                <button type="button" id="closeModalBtn" class="px-6 py-3 bg-gray-400 text-white rounded-lg hover:bg-gray-500 focus:outline-none text-sm w-32">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize DataTables with search, pagination, and entries per page
        $('#borrowingSlipTable').DataTable({
            "pageLength": 10, // Default entries per page
            "lengthMenu": [10, 25, 50, 100], // Options for number of entries per page
            "searching": true, // Enable search functionality
            "paging": true, // Enable pagination
            "ordering": false // Disable sorting for all columns
        });
        
        @if (session('success'))
        Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",  // Display the success message
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @endif


        // Open Modal
        $('#openModalBtn').click(function() {
            $('#createBorrowingSlipModal').removeClass('hidden');
        });

        // Close Modal
        $('#closeModalBtn').click(function() {
            $('#createBorrowingSlipModal').addClass('hidden');
        });

        // Edit Borrowing Slip
        $('.editBtn').click(function() {
            var slipId = $(this).data('id');
            window.location.href = '/borrowing-slip/' + slipId + '/edit'; // Redirect to the edit page
        });

        // Delete Borrowing Slip
        $('.deleteBtn').click(function() {
            var slipId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform AJAX delete request
                    axios.delete('/borrowing-slip/' + slipId)
                        .then(function(response) {
                            if (response.data.success) {
                                // Remove the row from the table
                                $('#row_' + slipId).remove();
                                Swal.fire(
                                    'Deleted!',
                                    'Your borrowing slip has been deleted.',
                                    'success'
                                );
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                            Swal.fire(
                                'Error!',
                                'There was an issue deleting the borrowing slip.',
                                'error'
                            );
                        });
                }
            });
        });
    });
</script>

@endsection
