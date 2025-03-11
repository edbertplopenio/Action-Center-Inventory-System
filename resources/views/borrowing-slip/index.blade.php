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
    <style>
        /* Table and form styling */
        .table-container {
            position: relative;
            max-height: 500px;
            overflow-y: auto;
        }

        .dataTables_paginate {
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        thead {
            background-color: #4C51BF;
        }

        tr {
            transition: background-color 0.3s ease;
        }

        tr:hover {
            background-color: transparent;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .bg-indigo-600 {
            background-color: #4C51BF;
        }

        .bg-indigo-700 {
            background-color: #434190;
        }

        .text-gray-700 {
            color: #4A5568;
        }

        .text-white {
            color: white;
        }

        .rounded-lg {
            border-radius: 10px;
        }

        .shadow-md {
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .hover\:bg-gray-50:hover {
            background-color: transparent;
        }

        .form-input {
            background-color: #f9fafb;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            border-color: #4C51BF;
            outline: none;
            box-shadow: 0 0 5px rgba(76, 81, 191, 0.3);
        }

        /* Added styling to make buttons aligned horizontally */
        .action-buttons {
            display: flex;
            justify-content: space-between;
            gap: 8px; /* Space between Edit and Delete buttons */
        }
    </style>
</head>

<!-- Borrowing Slip Table -->
<div class="container mx-auto p-6">
    <div class="bg-white p-6 shadow-lg rounded-lg h-full">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-4xl font-semibold text-gray-800">Borrowing Slips</h1>
            <button id="openModalBtn" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none transition duration-300">Create Borrowing Slip</button>
        </div>

        <!-- Borrowing Slips Table -->
        <div class="table-container overflow-x-auto">
            <table id="borrowingSlipTable" class="min-w-full bg-white shadow-md rounded-lg border-collapse">
                <thead class="bg-indigo-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left">Department</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Responsible Person</th>
                        <th class="px-6 py-3 text-left">Item Code</th>
                        <th class="px-6 py-3 text-left">Borrow Date</th>
                        <th class="px-6 py-3 text-left">Quantity</th>
                        <th class="px-6 py-3 text-left">Due Date</th>
                        <th class="px-6 py-3 text-left">Signature</th>
                        <th class="px-6 py-3 text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($borrowingSlips as $slip)
                    <tr class="border-b" id="row_{{ $slip->id }}">
                        <td class="px-6 py-4">{{ $slip->name }}</td>
                        <td class="px-6 py-4">{{ $slip->department }}</td>
                        <td class="px-6 py-4">{{ $slip->email }}</td>
                        <td class="px-6 py-4">{{ $slip->responsible_person }}</td>
                        <td class="px-6 py-4">{{ $slip->item_code }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($slip->borrow_date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">{{ $slip->quantity }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($slip->due_date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            @if($slip->signature)
                                <img src="{{ Storage::url($slip->signature) }}" alt="Signature" class="w-16 h-16 object-cover">
                            @else
                                No Signature
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="action-buttons">
                                <!-- Edit Button -->
                                <button class="editBtn bg-blue-600 text-white rounded px-4 py-2" 
                                    data-id="{{ $slip->id }}"
                                    data-name="{{ $slip->name }}"
                                    data-department="{{ $slip->department }}"
                                    data-email="{{ $slip->email }}"
                                    data-responsible_person="{{ $slip->responsible_person }}"
                                    data-item_code="{{ $slip->item_code }}"
                                    data-borrow_date="{{ $slip->borrow_date }}"
                                    data-quantity="{{ $slip->quantity }}"
                                    data-due_date="{{ $slip->due_date }}"
                                    data-signature="{{ $slip->signature }}">
                                    Edit
                                </button>

                                <!-- Delete Button -->
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
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit Borrowing Slip</h2>
        <form id="editBorrowingSlipForm" method="POST" action="{{ route('borrowing-slip.update', 'id') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Name Input -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="editName" class="form-input mt-1 block w-full" required>
            </div>

            <!-- Department Input -->
            <div class="mb-4">
                <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                <input type="text" name="department" id="editDepartment" class="form-input mt-1 block w-full" required>
            </div>

            <!-- Email Input -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="editEmail" class="form-input mt-1 block w-full" required>
            </div>

            <!-- Responsible Person Input -->
            <div class="mb-4">
                <label for="responsible_person" class="block text-sm font-medium text-gray-700">Responsible Person</label>
                <input type="text" name="responsible_person" id="editResponsiblePerson" class="form-input mt-1 block w-full" required>
            </div>

            <!-- Item Code Input -->
            <div class="mb-4">
                <label for="item_code" class="block text-sm font-medium text-gray-700">Item Code</label>
                <input type="text" name="item_code" id="editItemCode" class="form-input mt-1 block w-full" required>
            </div>

            <!-- Borrow Date Input -->
            <div class="mb-4">
                <label for="borrow_date" class="block text-sm font-medium text-gray-700">Borrow Date</label>
                <input type="date" name="borrow_date" id="editBorrowDate" class="form-input mt-1 block w-full" required>
            </div>

            <!-- Quantity Input -->
            <div class="mb-4">
                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" name="quantity" id="editQuantity" class="form-input mt-1 block w-full" required>
            </div>

            <!-- Due Date Input -->
            <div class="mb-4">
                <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                <input type="date" name="due_date" id="editDueDate" class="form-input mt-1 block w-full" required>
            </div>

            <!-- Signature File Input -->
            <div class="mb-4">
                <label for="signature" class="block text-sm font-medium text-gray-700">Signature</label>
                <input type="file" name="signature" id="editSignature" class="form-input mt-1 block w-full">
            </div>

            <!-- Submit and Cancel Buttons -->
            <div class="flex justify-end mt-4">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none">Save Changes</button>
                <button type="button" id="closeModalBtn" class="px-6 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 focus:outline-none ml-2">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
   $(document).ready(function() {
    // Open Edit Modal and populate the form
    $(document).on('click', '.editBtn', function() {
        var slipId = $(this).data('id');
        var name = $(this).data('name');
        var department = $(this).data('department');
        var email = $(this).data('email');
        var responsiblePerson = $(this).data('responsible_person');
        var itemCode = $(this).data('item_code');
        var borrowDate = $(this).data('borrow_date');
        var quantity = $(this).data('quantity');
        var dueDate = $(this).data('due_date');
        var signature = $(this).data('signature');

        // Populate the form fields
        $('#editName').val(name);
        $('#editDepartment').val(department);
        $('#editEmail').val(email);
        $('#editResponsiblePerson').val(responsiblePerson);
        $('#editItemCode').val(itemCode);
        $('#editBorrowDate').val(borrowDate);
        $('#editQuantity').val(quantity);
        $('#editDueDate').val(dueDate);
        $('#editSignature').val(signature);

        // Set the action URL for the edit form
        $('#editBorrowingSlipForm').attr('action', '/borrowing-slip/' + slipId);

        // Show the modal
        $('#createBorrowingSlipModal').removeClass('hidden');
    });

    // Close Modal
    $('#closeModalBtn').click(function() {
        $('#createBorrowingSlipModal').addClass('hidden');
    });

    // Initialize DataTables
    $('#borrowingSlipTable').DataTable({
        "pageLength": 10,
        "lengthMenu": [10, 25, 50, 100],
        "searching": true,
        "paging": true,
        "ordering": true,
        "columnDefs": [
            { "orderable": false, "targets": [1, 2, 3, 4, 5, 6, 7, 8, 9] },
            { "orderable": true, "targets": [0] }
        ]
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
