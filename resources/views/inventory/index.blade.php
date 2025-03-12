@extends('layouts.app')

@section('title', 'Inventory')

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

<!-- Equipment Table -->
<div class="container mx-auto p-6">
    <div class="bg-white p-6 shadow-lg rounded-lg h-full">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-4xl font-semibold text-gray-800">Equipment List</h1>
        </div>

        <!-- Equipment Table -->
        <div class="table-container overflow-x-auto">
            <table id="inventoryTable" class="min-w-full bg-white shadow-md rounded-lg border-collapse">
                <thead class="bg-indigo-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left">Item Name</th>
                        <th class="px-6 py-3 text-left">Category</th>
                        <th class="px-6 py-3 text-left">Quantity</th>
                        <th class="px-6 py-3 text-left">Unit</th>
                        <th class="px-6 py-3 text-left">Description</th>
                        <th class="px-6 py-3 text-left">Arrival Date</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Storage Location</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($items as $item)
                    <tr class="border-b">
                        <td class="px-6 py-4">{{ $item->item_name }}</td>
                        <td class="px-6 py-4">{{ $item->category }}</td>
                        <td class="px-6 py-4">{{ $item->quantity }}</td>
                        <td class="px-6 py-4">{{ $item->unit }}</td>
                        <td class="px-6 py-4">{{ $item->description }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item->arrival_date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-green-500">{{ ucfirst($item->status) }}</td>
                        <td class="px-6 py-4">{{ $item->storage_location }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination fixed to the bottom -->
            <div class="dataTables_paginate" style="position: absolute; bottom: 0; width: 100%; text-align: center;">
                <ul class="pagination">
                    <!-- Pagination items will be generated by DataTables -->
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#inventoryTable').DataTable();
    });
</script>

@endsection
