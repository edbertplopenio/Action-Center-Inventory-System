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

<style>
    /* Center table header and body content */
    #borrowedTable th, #borrowedTable td {
        text-align: center;
    }
</style>


</head>

<div class="mx-auto p-2" style="width: 1220px; height: 700px; font-family: 'Inter', sans-serif;">
    <div class="bg-white p-6 shadow-lg rounded-lg h-full">
        <div class="flex justify-between items-center mb-1 pt-0">
            <h1 class="text-3xl text-left">Borrowed Equipments</h1>
        </div>

        <div style="height: 625px; overflow-y: auto;">
            <table id="borrowedTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Quantity Borrowed</th>
                        <th>Unit</th>
                        <th>Borrow Date</th>
                        <th>Due Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                        <th>Responsible Person</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowed_items as $borrowed)
                    <tr class="borrowed-row cursor-pointer"
                        data-id="{{ $borrowed->id }}"
                        data-item-name="{{ $borrowed->item->name }}"
                        data-category="{{ $borrowed->item->category }}"
                        data-quantity="{{ $borrowed->quantity_borrowed }}"
                        data-unit="{{ $borrowed->item->unit }}"
                        data-borrow-date="{{ $borrowed->borrow_date }}"
                        data-due-date="{{ $borrowed->due_date }}"
                        data-return-date="{{ $borrowed->return_date ?? 'Not Returned' }}"
                        data-status="{{ $borrowed->status }}"
                        data-responsible-person="{{ $borrowed->responsible_person }}"
                        data-image-url="{{ $borrowed->item->image_url }}">

                        <td>{{ $borrowed->item->name }}</td>
                        <td>{{ $borrowed->item->category }}</td>
                        <td>{{ $borrowed->quantity_borrowed }}</td>
                        <td>{{ $borrowed->item->unit }}</td>
                        <td>{{ $borrowed->borrow_date }}</td>
                        <td>{{ $borrowed->due_date }}</td>
                        <td>{{ $borrowed->return_date ?? 'Not Returned' }}</td>
                        <td>
                            @if($borrowed->status == 'Pending')
                            <span class="badge badge-warning">{{ $borrowed->status }}</span>
                            @elseif($borrowed->status == 'Approved')
                            <span class="badge badge-success">{{ $borrowed->status }}</span>
                            @elseif($borrowed->status == 'Overdue')
                            <span class="badge badge-danger">{{ $borrowed->status }}</span>
                            @else
                            <span class="badge badge-secondary">{{ $borrowed->status }}</span>
                            @endif
                        </td>
                        <td>{{ $borrowed->responsible_person }}</td>
                        <td>
                            @if($borrowed->item->image_url)
                            <img src="{{ asset($borrowed->item->image_url) }}" alt="Item Image" style="width: 50px; height: 50px;">
                            @else
                            No Image
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr id="noRecordsRow">
                        <td colspan="10" class="text-center">No borrowed items found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>


<script>
    $(document).ready(function() {
        let table = $('#borrowedTable');

        // Remove "No records found" row if present
        if (table.find("tbody tr").length === 1 && table.find("#noRecordsRow").length === 1) {
            table.find("#noRecordsRow").remove(); // Remove "No records found" row
        }

        // Initialize DataTables with additional settings
        table.DataTable({
            scrollY: '425px',
            scrollCollapse: true,
            scrollX: false,
            paging: true,
            searching: true,
            ordering: true,

        });
    });
</script>

@endsection