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
        #borrowedTable th,
        #borrowedTable td {
            text-align: center;
        }
    </style>


</head>

<div class="mx-auto p-2" style="width: 1220px; height: 700px; font-family: 'Inter', sans-serif;">
    <div class="bg-white p-6 shadow-lg rounded-lg h-full">
        <div class="flex justify-between items-center mb-1 pt-0">
            <h1 class="text-3xl text-left">Borrowed Equipments</h1>
            <div class="flex space-x-2 w-auto">
                <button id="openModal" type="button" class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    Generate Report
                </button>

            </div>
        </div>

        <div style="height: 620px; overflow-y: auto;">
            <table id="borrowedTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="display:none;">ID</th> <!-- Hidden ID column -->
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Quantity Borrowed</th>
                        <th>Unit</th>
                        <th>Borrow Date</th>
                        <th>Due Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                        <th style="min-width: 150px;">
                            Responsible Person <br>
                            <span style="display: flex; justify-content: space-between; font-weight: normal;">
                                <span>Request</span>
                                <span>Return</span>
                            </span>
                        </th>
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

        <td style="display:none;">{{ $borrowed->id }}</td> <!-- Hidden ID column -->
        <td>{{ $borrowed->item->name }}</td>
        <td>{{ $borrowed->item->category }}</td>
        <td>{{ $borrowed->quantity_borrowed }}</td>
        <td>{{ $borrowed->item->unit }}</td>
        <td>{{ $borrowed->borrow_date }}</td>
        <td>{{ $borrowed->due_date }}</td>
        <td>{{ $borrowed->return_date ?? 'Not Returned' }}</td>
        <td>
            <span class="px-3 py-1 text-xs font-semibold rounded w-24 text-center inline-block
                {{ $borrowed->status == 'Pending' ? 'bg-yellow-500/10 text-yellow-500 border border-yellow-500' : '' }}
                {{ $borrowed->status == 'Approved' ? 'bg-green-500/10 text-green-500 border border-green-500' : '' }}
                {{ $borrowed->status == 'Rejected' ? 'bg-red-500/10 text-red-500 border border-red-500' : '' }}
                {{ $borrowed->status == 'Borrowed' ? 'bg-blue-500/10 text-blue-500 border border-blue-500' : '' }}
                {{ $borrowed->status == 'Returned' ? 'bg-purple-500/10 text-purple-500 border border-purple-500' : '' }}
                {{ $borrowed->status == 'Overdue' ? 'bg-orange-500/10 text-orange-500 border border-orange-500' : '' }}">
                {{ $borrowed->status }}
            </span>
        </td>
        <td>
            <div style="display: flex; justify-content: space-between; width: 100%;">
                <div style="flex: 1; text-align: center;">

                    {{ $borrowed->request_responsible_person ?? 'N/A' }}
                </div>
                <div style="flex: 1; text-align: center;">

                    {{ $borrowed->return_responsible_person ?? 'N/A' }}
                </div>
            </div>
        </td>
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




<div id="myModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50"></div>

    <!-- Modal Content -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-3xl overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Generate Report</h3>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-4 space-y-4">
                <!-- Date Filters -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="startDate" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" id="startDate" name="startDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-200">
                    </div>
                    <div>
                        <label for="endDate" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" id="endDate" name="endDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-200">
                    </div>
                </div>

                <!-- Status Dropdown -->
                <div>
                    <label for="statusFilter" class="block text-sm font-medium text-gray-700">Filter by Status</label>
                    <select id="statusFilter" name="statusFilter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-200">
                        <option value="all">All</option>
                        <option value="Borrowed">Borrowed</option>
                        <option value="Pending">Pending</option>
                    </select>
                </div>

                <!-- Report Preview -->
                <div id="reportContent" class="p-4 border rounded bg-gray-100 text-sm">
                    <p class="text-gray-700">This is a sample report content. Modify it as needed.</p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 border-t flex justify-end gap-3">
                <button id="printReport" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Print Report
                </button>
                <button id="closeModal" class="px-4 py-2 bg-gray-300 text-black rounded hover:bg-gray-400">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>


<!-- JS should be below the modal or in your scripts file -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    let reportData = []; // Make it globally scoped within this function

    // Fetch data once on load
    fetch('/borrower/borrow-equipment/report-preview')
        .then(response => response.json())
        .then(data => {
            reportData = data;
            renderReport(reportData); // initial render
        });

    // Handle status filter change
    const statusFilter = document.getElementById('statusFilter');
    statusFilter.addEventListener('change', function () {
        const selectedStatus = this.value;
        const filteredData = selectedStatus === "all"
            ? reportData
            : reportData.filter(item => item.status === selectedStatus);
        renderReport(filteredData);
    });

    // Reusable render function
    function renderReport(data) {
        const reportDiv = document.getElementById('reportContent');
        if (data.length === 0) {
            reportDiv.innerHTML = '<p class="text-gray-700">No data available.</p>';
            return;
        }

        let html = `<table class="table-auto w-full text-sm text-left text-gray-700 border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">Item Name</th>
                    <th class="p-2 border">Quantity</th>
                    <th class="p-2 border">Borrow Date</th>
                    <th class="p-2 border">Due Date</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Responsible Person</th>
                </tr>
            </thead>
            <tbody>`;

        data.forEach(item => {
            html += `<tr>
                <td class="p-2 border">${item.item?.name ?? 'N/A'}</td>
                <td class="p-2 border">${item.quantity_borrowed}</td>
                <td class="p-2 border">${item.borrow_date}</td>
                <td class="p-2 border">${item.due_date}</td>
                <td class="p-2 border">${item.status}</td>
                <td class="p-2 border">${item.responsible_person}</td>
            </tr>`;
        });

        html += '</tbody></table>';
        reportDiv.innerHTML = html;
    }
});
</script>




<script>
    document.addEventListener("DOMContentLoaded", function() {
        const openModalBtn = document.getElementById("openModal");
        const modal = document.getElementById("myModal");
        const closeModalBtn = document.getElementById("closeModal");
        const printBtn = document.getElementById("printReport");

        // Open modal
        openModalBtn.addEventListener("click", function() {
            modal.style.display = "block";
        });

        // Close modal
        closeModalBtn.addEventListener("click", function() {
            modal.style.display = "none";
        });

        // Print report
        printBtn.addEventListener("click", function() {
            const printContent = document.getElementById("reportContent").innerHTML;
            const printWindow = window.open("", "", "width=800,height=600");
            printWindow.document.write(`<html><head><title>Print Report</title></head><body>${printContent}</body></html>`);
            printWindow.document.close();
            printWindow.print();
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let reportData = [];

    const statusFilter = document.getElementById('statusFilter');
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    const reportDiv = document.getElementById('reportContent');

    function fetchAndRenderData() {
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;

        let url = '/borrower/borrow-equipment/report-preview';

        if (startDate && endDate) {
            url += `?startDate=${startDate}&endDate=${endDate}`;
        }

        fetch(url)
            .then(response => response.json())
            .then(data => {
                reportData = data;
                applyFilters();
            });
    }

    function applyFilters() {
    const selectedStatus = statusFilter.value;
    const startDate = startDateInput.value;
    const endDate = endDateInput.value;

    let filteredData = reportData;

    // Filter by status if not 'all'
    if (selectedStatus !== "all") {
        filteredData = filteredData.filter(item => item.status === selectedStatus);
    }

    // Filter by borrow_date if both dates are provided
    if (startDate && endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        filteredData = filteredData.filter(item => {
            const borrowDate = new Date(item.borrow_date);
            return borrowDate >= start && borrowDate <= end;
        });
    }

    renderReport(filteredData);
}

function renderReport(data) {
    if (!data || data.length === 0) {
        reportContent.innerHTML = '<p class="text-gray-700">No data available.</p>';
        return;
    }

    let html = `<table class="table-auto w-full text-sm text-left text-gray-700 border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">Item Name</th>
                <th class="p-2 border">Quantity</th>
                <th class="p-2 border">Borrow Date</th>
                <th class="p-2 border">Due Date</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Responsible Person</th>
            </tr>
        </thead>
        <tbody>`;

    data.forEach(item => {
        // Filter out incomplete data client-side too, just in case
        if (!item.item || !item.item.name || item.quantity_borrowed <= 0) return;

        html += `<tr>
            <td class="p-2 border">${item.item.name}</td>
            <td class="p-2 border">${item.quantity_borrowed}</td>
            <td class="p-2 border">${item.borrow_date}</td>
            <td class="p-2 border">${item.due_date}</td>
            <td class="p-2 border">${item.status}</td>
            <td class="p-2 border">${item.responsible_person}</td>
        </tr>`;
    });

    html += '</tbody></table>';
    reportContent.innerHTML = html;
}



    // Event listeners
    statusFilter.addEventListener('change', applyFilters);
    startDateInput.addEventListener('change', fetchAndRenderData);
    endDateInput.addEventListener('change', fetchAndRenderData);

    // Initial fetch
    fetchAndRenderData();
    function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toISOString().split("T")[0];  // Outputs: YYYY-MM-DD
}
});
</script>







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
            "order": [
                [0, "desc"] // Sort by hidden ID column (index 0)
            ],
            "columnDefs": [{
                "targets": 0,
                "visible": false // Hide ID column
            }]
        });
    });
</script>



@endsection