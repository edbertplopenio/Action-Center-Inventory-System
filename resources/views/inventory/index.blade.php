@extends('layouts.app')

@section('title', 'Inventory')

@section('content')
    <div class="container mx-auto p-6">
        <!-- Single Card for Inventory -->
        <div class="mx-auto p-6" style="width: 1220px; height: 710px;">
            <h1 class="text-2xl font-semibold mb-4">Inventory Page</h1>
            <p class="mb-4">Manage and view your inventory items below.</p>

            <!-- Table for displaying inventory items -->
            <div class="overflow-x-auto h-[calc(100%-120px)]"> <!-- Adjusting table height -->
                <table id="inventoryTable" class="min-w-full table-auto bg-white border border-gray-300 shadow-sm rounded-lg">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left text-gray-600">Item ID</th>
                            <th class="px-4 py-2 text-left text-gray-600">Item Name</th>
                            <th class="px-4 py-2 text-left text-gray-600">Quantity</th>
                            <th class="px-4 py-2 text-left text-gray-600">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample inventory row -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-gray-700">1</td>
                            <td class="px-4 py-2 text-gray-700">Laptop</td>
                            <td class="px-4 py-2 text-gray-700">20</td>
                            <td class="px-4 py-2 text-gray-700">Available</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-gray-700">2</td>
                            <td class="px-4 py-2 text-gray-700">Monitor</td>
                            <td class="px-4 py-2 text-gray-700">15</td>
                            <td class="px-4 py-2 text-gray-700">Out of Stock</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#inventoryTable').DataTable(); // Initialize DataTable on your table
        });
    </script>
@endpush
