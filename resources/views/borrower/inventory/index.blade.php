@extends('layouts.app')

@section('title', 'Inventory Records')

@section('content')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Add Google Fonts link for Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">

    <!-- Include jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>

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
        <div class="flex justify-between items-center mb-1 pt-0">
            <h1 class="text-3xl text-left">Inventory</h1>
        </div>

        <div style="height: 625px; overflow-y: auto;">
            <table id="myTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->category }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            @if($item->image_url)
                            <img src="{{ $item->image_url }}" alt="Item Image" style="width: 50px; height: 50px;">
                            @else
                            No Image
                            @endif
                        </td>
                        <td>
                            <button
                                class="borrow-btn px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24"
                                onclick="borrowItem('{{ $item->id }}', '{{ $item->quantity }}')">
                                Borrow
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr id="noRecordsRow">
                        <td colspan="8" class="text-center">No items found.</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>







<!-- Modal -->



<!-- Borrow Item Modal -->
<!-- Borrow Item Modal -->
<div class="relative z-10 hidden" id="borrowModal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black/50 transition-opacity"></div>
    <div class="fixed inset-0 z-10 flex items-center justify-center">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">
            <div class="bg-white px-6 py-5 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Enter Borrow Details</h3>

                <!-- Modal Form -->
                <form id="borrowForm">
                    <div class="space-y-4">
                        <!-- Borrow Date -->
                        <div>
                            <label for="borrow-date" class="block text-xs font-medium text-gray-900">Borrow Date</label>
                            <input type="date" id="borrow-date" required class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-xs">
                            <p class="text-xs text-red-500 hidden" id="borrow-date-error">Please select a borrow date.</p>
                        </div>

                        <!-- Due Date -->
                        <div>
                            <label for="due-date" class="block text-xs font-medium text-gray-900">Due Date</label>
                            <input type="date" id="due-date" required class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-xs">
                            <p class="text-xs text-red-500 hidden" id="due-date-error">Please select a due date.</p>
                        </div>

                        <!-- Quantity (Two-Column Layout) -->
                        <div>
                            <label class="block text-xs font-medium text-gray-900">Quantity</label>
                            <div class="grid grid-cols-2 gap-4 mt-1">
                                <!-- Current Quantity -->
                                <div class="flex flex-col">
                                    <span class="text-xs font-medium text-gray-600">Current Quantity</span>
                                    <input type="text" id="current-quantity" class="py-1.5 px-3 border border-gray-300 rounded-md bg-gray-100 text-center sm:text-xs" readonly>
                                </div>

                                <!-- Quantity to Borrow -->
                                <div class="flex flex-col">
                                    <span class="text-xs font-medium text-gray-600">Quantity to Borrow</span>
                                    <input type="number" id="borrow-quantity" min="1" required class="py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-xs text-center">
                                    <p class="text-xs text-red-500 hidden" id="borrow-quantity-error">Enter a valid quantity.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden field for Item ID -->
                    <input type="hidden" id="borrow-item-id">

                    <!-- Action Buttons -->
                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <button type="button" class="text-xs font-semibold text-gray-900 hover:text-gray-600" id="closeBorrowModalBtn">Cancel</button>
                        <button type="submit" class="rounded-md bg-blue-600 px-3 py-2 text-xs font-semibold text-white shadow-xs hover:bg-blue-500">Confirm Borrow</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>






<script>
document.addEventListener("DOMContentLoaded", function() {
    const borrowModal = document.getElementById("borrowModal");
    const closeBorrowModalBtn = document.getElementById("closeBorrowModalBtn");
    const borrowForm = document.getElementById("borrowForm");
    const borrowDateInput = document.getElementById("borrow-date");
    const dueDateInput = document.getElementById("due-date");
    const quantityInput = document.getElementById("borrow-quantity"); // Quantity to borrow input
    const currentQuantityInput = document.getElementById("current-quantity"); // Current quantity in modal
    const errorMessageDiv = document.getElementById("error-message"); // Div for displaying errors

    let selectedItemId = null;
    let currentQuantity = 0; // Store the initial current quantity for the item

    // Function to get today's date in YYYY-MM-DD format
    function getCurrentDate() {
        const today = new Date();
        return today.toISOString().split("T")[0]; // Format: YYYY-MM-DD
    }

    // Open Borrow Details Modal directly
    window.borrowItem = function(itemId, itemCurrentQuantity) {
        selectedItemId = itemId;
        currentQuantity = itemCurrentQuantity; // Set the current quantity for the item
        borrowModal.style.display = "block";
        document.getElementById("borrow-item-id").value = selectedItemId;
        borrowDateInput.value = getCurrentDate(); // Auto-fill borrow date
        currentQuantityInput.value = currentQuantity; // Set the current quantity in the modal
    };

    // When quantity to borrow is changed, calculate the remaining quantity
    quantityInput.addEventListener("input", function() {
        const borrowQuantity = parseInt(quantityInput.value) || 0;
        const remainingQuantity = currentQuantity - borrowQuantity;
        
        // Update the current quantity dynamically based on what is entered
        currentQuantityInput.value = remainingQuantity >= 0 ? remainingQuantity : currentQuantity;

        // If the quantity to borrow exceeds current quantity, show error
        if (remainingQuantity < 0) {
            quantityInput.setCustomValidity("Quantity to borrow cannot exceed the available quantity.");
            quantityInput.reportValidity(); // Trigger the validation UI
        } else {
            quantityInput.setCustomValidity(""); // Reset the custom validity
        }
    });

    // Check if Due Date is later than Borrow Date
    function validateDueDate() {
        const borrowDate = new Date(borrowDateInput.value);
        const dueDate = new Date(dueDateInput.value);

        if (dueDate <= borrowDate) {
            dueDateInput.setCustomValidity("Due Date must be later than Borrow Date.");
            dueDateInput.reportValidity(); // Trigger the validation UI
        } else {
            dueDateInput.setCustomValidity(""); // Reset the custom validity
        }
    }

    // Listen for changes in Due Date and validate it
    dueDateInput.addEventListener("input", validateDueDate);

    // Close Borrow Modal and reset form fields
    closeBorrowModalBtn.addEventListener("click", function() {
        borrowModal.style.display = "none";
        
        // Reset the fields to ensure no previous data is left
        borrowForm.reset();
        currentQuantityInput.value = ""; // Clear current quantity display
        errorMessageDiv.innerHTML = ""; // Clear error messages
    });

    // Borrow Form Validation & Submission
    borrowForm.addEventListener("submit", function(event) {
        event.preventDefault();
        errorMessageDiv.innerHTML = ""; // Clear previous errors

        const borrowDate = borrowDateInput.value.trim();
        const dueDate = dueDateInput.value.trim();
        const borrowQuantity = quantityInput.value.trim();

        let errors = [];

        // Field Validation
        if (!borrowDate) errors.push("Borrow Date is required.");
        if (!dueDate) errors.push("Due Date is required.");
        if (!borrowQuantity) errors.push("Quantity is required.");

        // Show Errors if any
        if (errors.length > 0) {
            errorMessageDiv.innerHTML = errors.map(error => `<p style="color:red;">${error}</p>`).join("");
            return;
        }

        // Proceed with Submission if No Errors
        fetch("/borrow-item", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                },
                body: JSON.stringify({
                    item_id: selectedItemId,
                    borrow_date: borrowDate,
                    due_date: dueDate,
                    quantity: borrowQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Item borrowed successfully!");
                    borrowModal.style.display = "none"; // Close modal
                } else {
                    alert("Error borrowing item.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Something went wrong.");
            });
    });
});

$(document).ready(function() {
    $('#myTable').DataTable({
        scrollY: '425px',
        scrollCollapse: true,
        paging: true,
        searching: true,
        ordering: true
    });
});



</script>



<!-- Success/Error Modal -->
<div class="relative z-20 hidden" id="messageModal" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black/50 transition-opacity"></div>
    <div class="fixed inset-0 z-20 flex items-center justify-center">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">
            <div class="bg-white px-6 py-5 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <!-- Icon -->
                    <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-gray-100 sm:mx-0 sm:size-10">
                        <svg id="modal-icon" class="size-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path id="modal-icon-path" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <!-- Message Content -->
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-base font-semibold text-gray-900" id="modal-title">Message Title</h3>
                        <p class="mt-2 text-sm text-gray-500" id="modal-message">Message description goes here.</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                <button type="button" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-blue-500 sm:ml-3 sm:w-auto" id="closeMessageModalBtn">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Borrow Confirmation Modal -->
<div class="relative z-10 hidden" id="confirmationModal" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 flex items-center justify-center">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-yellow-100 sm:mx-0 sm:size-10">
                        <svg class="size-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-base font-semibold text-gray-900">Confirm Borrow</h3>
                        <p class="mt-2 text-sm text-gray-500">Are you sure you want to borrow this item?</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                <button type="button" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-blue-500 sm:ml-3 sm:w-auto" id="confirmBorrowBtn">Yes, Borrow</button>
                <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto" id="cancelBorrowBtn">Cancel</button>
            </div>
        </div>
    </div>
</div>



@endsection