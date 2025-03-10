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
        /* Table and form styling */
        .table-container {
            position: relative; /* Make sure the pagination is relative to this container */
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
            transition: background-color 0.3s ease; /* Transition for hover */
        }

        tr:hover {
            background-color: transparent; /* Remove hover effect */
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
            background-color: transparent; /* No hover effect */
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

        .bg-gray-400 {
            background-color: #D1D5DB;
        }

        .bg-gray-500 {
            background-color: #6B7280;
        }

        .bg-indigo-600 {
            background-color: #4C51BF;
        }

        .bg-indigo-700 {
            background-color: #434190;
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
