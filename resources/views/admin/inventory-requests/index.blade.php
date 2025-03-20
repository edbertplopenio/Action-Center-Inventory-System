@extends('layouts.app')

@section('title', 'Borrowing Requests')

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

    <style>
        /* Center table header and body content */
        #requestsTable th,
        #requestsTable td {
            text-align: center;
        }
    </style>


</head>

<div class="mx-auto p-2" style="width: 1220px; height: 700px; font-family: 'Inter', sans-serif;">
    <div class="bg-white p-6 shadow-lg rounded-lg h-full">
        <div class="flex justify-between items-center mb-4 pt-0">
            <h1 class="text-3xl text-left">Borrowing Requests</h1>
        </div>

        <div style="height: 550px; overflow-y: auto;">
            <table id="requestsTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Borrower</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Borrow Date</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
    @forelse($borrowing_requests as $request)
    <tr>
        <td>
            @if($request->borrower)
            {{ $request->borrower->first_name }} {{ $request->borrower->last_name }}
            @else
            <span class="text-red-500">No Borrower Found</span>
            @endif
        </td>

        <td>{{ $request->item->name }}</td>
        <td>{{ $request->quantity_borrowed }}</td>
        <td>{{ \Carbon\Carbon::parse($request->borrow_date)->format('Y-m-d') }}</td>
        <td>{{ \Carbon\Carbon::parse($request->due_date)->format('Y-m-d') }}</td>
        <td>
            <span class="px-3 py-1 text-xs font-semibold rounded w-24 text-center inline-block
                {{ $request->status == 'Pending' ? 'bg-yellow-500/10 text-yellow-500 border border-yellow-500' : '' }}
                {{ $request->status == 'Approved' ? 'bg-green-500/10 text-green-500 border border-green-500' : '' }}
                {{ $request->status == 'Rejected' ? 'bg-red-500/10 text-red-500 border border-red-500' : '' }}
                {{ $request->status == 'Borrowed' ? 'bg-blue-500/10 text-blue-500 border border-blue-500' : '' }}
                {{ $request->status == 'Returned' ? 'bg-purple-500/10 text-purple-500 border border-purple-500' : '' }}
                {{ $request->status == 'Overdue' ? 'bg-orange-500/10 text-orange-500 border border-orange-500' : '' }}
                {{ $request->status == 'Lost' ? 'bg-gray-500/10 text-gray-500 border border-gray-500' : '' }}
                {{ $request->status == 'Damaged' ? 'bg-pink-500/10 text-pink-500 border border-pink-500' : '' }}">
                {{ $request->status }}
            </span>
        </td>
        <td>
            <button class="approve-btn px-2 py-1 m-1 bg-green-500 text-white rounded 
            hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 text-xs w-24"
                onclick="updateStatus('{{ $request->id }}', 'Approved')">
                Approve
            </button>

            <button class="reject-btn px-2 py-1 m-1 bg-red-500 text-white rounded 
            hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 text-xs w-24"
                onclick="updateStatus('{{ $request->id }}', 'Rejected')">
                Reject
            </button>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="7" class="text-center">No borrowing requests found.</td>
    </tr>
    @endforelse
</tbody>

            </table>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#requestsTable').DataTable({
            scrollY: '420px',
            scrollCollapse: true,
            paging: true,
            searching: true,
            ordering: true
        });
    });

    function updateStatus(id, status) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You are about to " + status.toLowerCase() + " this request.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: status === 'Approved' ? '#28a745' : '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, ' + status.toLowerCase() + ' it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/inventory-requests/update-status/' + id,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    status: status
                },
                success: function(response) {
                    Swal.fire('Updated!', 'The request has been ' + status.toLowerCase() + '.', 'success')
                        .then(() => {
                            location.reload();
                        });
                },
                error: function() {
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                }
            });
        }
    });
}

</script>


@endsection