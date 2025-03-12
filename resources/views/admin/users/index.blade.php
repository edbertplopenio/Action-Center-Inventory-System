@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="mx-auto p-6" style="width: 1220px; height: 710px;">
        <div class="bg-white p-6 shadow-lg rounded-lg h-full">
            <h1 class="text-2xl font-semibold mb-4">Users Page</h1>
            <p class="mb-4">Here you can manage and view the list of users.</p>

            <!-- Table for displaying users -->
            <div class="overflow-x-auto h-[calc(100%-120px)]"> <!-- Adjusting table height -->
                <table id="usersTable" class="min-w-full table-auto bg-white border border-gray-300 shadow-sm rounded-lg">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left text-gray-600">User ID</th>
                            <th class="px-4 py-2 text-left text-gray-600">Name</th>
                            <th class="px-4 py-2 text-left text-gray-600">Email</th>
                            <th class="px-4 py-2 text-left text-gray-600">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample user row -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-gray-700">1</td>
                            <td class="px-4 py-2 text-gray-700">Camdice Mier</td>
                            <td class="px-4 py-2 text-gray-700">camdice@example.com</td>
                            <td class="px-4 py-2 text-gray-700">Active</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-gray-700">2</td>
                            <td class="px-4 py-2 text-gray-700">John Doe</td>
                            <td class="px-4 py-2 text-gray-700">john.doe@example.com</td>
                            <td class="px-4 py-2 text-gray-700">Inactive</td>
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
            $('#usersTable').DataTable(); // Initialize DataTable on your table
        });
    </script>
@endpush
