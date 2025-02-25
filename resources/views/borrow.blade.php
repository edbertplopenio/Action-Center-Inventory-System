<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Hide all tables by default, only show the active tab's table */
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }

        /* Custom tab color styles */
        .tab-button {
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            color: white;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .tab-button:hover {
            opacity: 0.8;
        }

        .tab-button.active {
            font-weight: bold;
        }

        /* Flex container for Tabs */
        .tab-container {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .tab-button-container {
            display: flex;
        }

        .tab-button + .tab-button {
            margin-left: 0.5rem;
        }

        /* Custom Tab Colors */
        .borrowed-records-tab {
            background-color: #4A90E2; /* Blue */
        }

        .pending-request-tab {
            background-color: #FF9F00; /* Orange */
        }

        .record-of-borrowed-items-tab {
            background-color: #FF5733; /* Red */
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
            font-size: 0.875rem; /* Smaller font size for better alignment */
        }

        table th, table td {
            padding: 0.6rem; /* Reduced padding */
            text-align: left;
            border-bottom: 1px solid #E5E5E5;
        }

        table th {
            background-color: #F7FAFC;
            color: #2D3748;
            font-size: 0.875rem; /* Match font size with table cells */
        }

        table tr:hover {
            background-color: #F1F1F1;
        }

        .table-container {
            overflow-x: auto;
            width: 100%;
            height: 550px;
            overflow-y: auto; /* Enable vertical scrolling if needed */
            margin-top: -1.5rem; /* Set to 0 or a smaller value to move the table up */
            position: relative;
        }

        /* Styling for the Action Buttons */
        .action-btn {
            padding: 0.4rem 0.8rem;
            border-radius: 0.25rem;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 600;
            margin-right: 0.5rem;
        }

        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }

        .edit-btn:hover {
            background-color: #45A049;
        }

        .delete-btn {
            background-color: #F44336;
            color: white;
        }

        .delete-btn:hover {
            background-color: #F41F29;
        }

        .approve-btn {
            background-color: #4CAF50;
            color: white;
        }

        .approve-btn:hover {
            background-color: #45A049;
        }

        .reject-btn {
            background-color: #F44336;
            color: white;
        }

        .reject-btn:hover {
            background-color: #F41F29;
        }

        .return-btn {
            background-color: #4CAF50;
            color: white;
        }

        .return-btn:hover {
            background-color: #45A049;
        }

        .extend-btn {
            background-color: #FF9F00;
            color: white;
        }

        .extend-btn:hover {
            background-color: #F99C1D;
        }

        .input {
            padding: 0.5rem;
            border-radius: 0.25rem;
            width: 100%;
            border: 1px solid #E5E5E5;
        }

        .btn {
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            color: white;
            cursor: pointer;
        }

        .btn-green {
            background-color: #38A169;
        }

        .btn-green:hover {
            background-color: #2F9C5A;
        }

        /* Pagination container */
        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            position: absolute;
            bottom: 1px; /* Adjust distance from the bottom */
            width: 100%;
        }

        /* Pagination button styles */
        .pagination-btn {
            font-size: 0.75rem; /* Smaller font size */
            padding: 0.4rem 0.8rem; /* Smaller padding */
            border-radius: 0.25rem;
            cursor: pointer;
            background-color: #f7fafc;
            border: 1px solid #e5e5e5;
            color: #2d3748;
        }

        /* Hover effect for pagination buttons */
        .pagination-btn:hover {
            background-color: #e2e8f0;
        }

        /* Disabled button state */
        .pagination-btn:disabled {
            background-color: #edf2f7;
            cursor: not-allowed;
        }

        /* Custom Sorting Arrow */
        .sortable::after {
            content: ' ▼';
            font-size: 0.7rem;
        }

        .sortable.asc::after {
            content: ' ▲';
        }

        .sortable.desc::after {
            content: ' ▼';
        }

    </style>
</head>
<body class="bg-gray-100">

<!-- Main Content -->
<div class="flex-1 p-6 relative">
    <div class="bg-white shadow-md rounded-lg p-6">
        <!-- Tabs -->
        <div class="tab-container">
            <div class="tab-button-container">
                <button id="borrowed-records-tab" class="tab-button borrowed-records-tab" onclick="switchTab('borrowed-records')">Borrowed Records</button>
                <button id="pending-request-tab" class="tab-button pending-request-tab ml-2" onclick="switchTab('pending-request')">Pending Request</button>
                <button id="record-of-borrowed-items-tab" class="tab-button record-of-borrowed-items-tab ml-2" onclick="switchTab('record-of-borrowed-items')">Record Of Borrowed Items</button>
            </div>
        </div>

        <!-- Tab Content (Tables for Borrowed Records, Pending Request, and Record Of Borrowed Items) -->
        <div id="borrowed-records-content" class="tab-content active">
            <h3 class="text-xl font-semibold">Borrowed Records</h3>
            <div class="table-container">
                <table id="borrowed-records-table">
                <thead>
                    <tr>
                    <th class="sortable" onclick="sortTable('borrowed-records-table', 0)">Name</th>
                    <th class="sortable" onclick="sortTable('borrowed-records-table', 1)">Department/Designation</th>
                    <th class="sortable" onclick="sortTable('borrowed-records-table', 2)">Email</th>
                    <th class="sortable" onclick="sortTable('borrowed-records-table', 3)">Person Responsible</th>
                    <th class="sortable" onclick="sortTable('borrowed-records-table', 4)">Borrow Date</th>
                    <th class="sortable" onclick="sortTable('borrowed-records-table', 5)">Items/Code</th>
                    <th class="sortable" onclick="sortTable('borrowed-records-table', 6)">Unit</th>
                    <th class="sortable" onclick="sortTable('borrowed-records-table', 7)">Quantity</th>
                    <th class="sortable" onclick="sortTable('borrowed-records-table', 8)">Due Date</th>

                        <th>Signature</th>
                        <th>Action</th>
                    </tr>
                </thead>
                    <tbody>
                        <!-- Example Data for Borrowed Records -->
                        <tr>
                            <td>John Doe</td>
                            <td>IT Department</td>
                            <td>johndoe@email.com</td>
                            <td>Jane Smith</td>
                            <td>2025-02-15</td>
                            <td>ABC123</td>
                            <td>Unit</td>
                            <td>2</td>
                            <td>2025-03-01</td>
                            <td><img src="signature.jpg" alt="Signature" class="w-20 h-10"></td>
                            <td>
                                <button class="return-btn action-btn">Return</button>
                                <button class="extend-btn action-btn">Extend</button>
                            </td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
                <div class="pagination-container mt-4">
                    <button class="pagination-btn">Previous</button>
                    <button class="pagination-btn">1</button>
                    <button class="pagination-btn">2</button>
                    <button class="pagination-btn">3</button>
                    <button class="pagination-btn">Next</button>
                </div>
            </div>
        </div>

        <div id="pending-request-content" class="tab-content">
            <h3 class="text-xl font-semibold">Pending Request</h3>
            <div class="table-container">
                <table id="pending-request-table">
                <thead>
                    <tr>
                        <th class="sortable" onclick="sortTable(0)">Name</th>
                        <th class="sortable" onclick="sortTable(1)">Department/Designation</th>
                        <th class="sortable" onclick="sortTable(2)">Email</th>
                        <th class="sortable" onclick="sortTable(3)">Person Responsible</th>
                        <th class="sortable" onclick="sortTable(4)">Borrow Date</th>
                        <th class="sortable" onclick="sortTable(5)">Items/Code</th>
                        <th class="sortable" onclick="sortTable(6)">Unit</th>
                        <th class="sortable" onclick="sortTable(7)">Quantity</th>
                        <th class="sortable" onclick="sortTable(8)">Due Date</th>
                        <th>Signature</th>
                        <th>Action</th>
                    </tr>
                </thead>
                    <tbody>
                        <!-- Example Data for Pending Request -->
                        <tr>
                            <td>Sarah Lee</td>
                            <td>HR Department</td>
                            <td>sarahlee@email.com</td>
                            <td>Michael Brown</td>
                            <td>2025-02-18</td>
                            <td>DEF456</td>
                            <td>Unit</td>
                            <td>1</td>
                            <td>2025-02-25</td>
                            <td><img src="signature.jpg" alt="Signature" class="w-20 h-10"></td>
                            <td>
                                <button class="approve-btn action-btn">Approve</button>
                                <button class="reject-btn action-btn">Reject</button>
                            </td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
                <div class="pagination-container mt-4">
                    <button class="pagination-btn">Previous</button>
                    <button class="pagination-btn">1</button>
                    <button class="pagination-btn">2</button>
                    <button class="pagination-btn">3</button>
                    <button class="pagination-btn">Next</button>
                </div>
            </div>
        </div>

        <div id="record-of-borrowed-items-content" class="tab-content">
            <h3 class="text-xl font-semibold">Record Of Borrowed Items</h3>
            <div class="table-container">
                <table id="record-of-borrowed-items-table">
                    <thead>
                        <tr>
                            <th class="sortable" onclick="sortTable(0)">Name</th>
                            <th class="sortable" onclick="sortTable(1)">Department/Designation</th>
                            <th class="sortable" onclick="sortTable(2)">Email</th>
                            <th class="sortable" onclick="sortTable(3)">Person Responsible</th>
                            <th class="sortable" onclick="sortTable(4)">Borrow Date</th>
                            <th class="sortable" onclick="sortTable(5)">Items/Code</th>
                            <th class="sortable" onclick="sortTable(6)">Unit</th>
                            <th class="sortable" onclick="sortTable(7)">Quantity</th>
                            <th class="sortable" onclick="sortTable(8)">Due Date</th>
                            <th>Signature</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example Data for Record Of Borrowed Items -->
                        <tr>
                            <td>John Doe</td>
                            <td>IT Department</td>
                            <td>johndoe@email.com</td>
                            <td>Jane Smith</td>
                            <td>2025-02-15</td>
                            <td>ABC123</td>
                            <td>Unit</td>
                            <td>2</td>
                            <td>2025-03-01</td>
                            <td><img src="signature.jpg" alt="Signature" class="w-20 h-10"></td>
                            <td>
                                <button class="edit-btn action-btn">Edit</button>
                                <button class="delete-btn action-btn">Delete</button>
                            </td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
                <div class="pagination-container mt-4">
                    <button class="pagination-btn">Previous</button>
                    <button class="pagination-btn">1</button>
                    <button class="pagination-btn">2</button>
                    <button class="pagination-btn">3</button>
                    <button class="pagination-btn">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Tab Switching and Pagination -->
<script>
    let currentPage = 1;
    let rowsPerPage = 5;  // Number of rows per page

    function switchTab(tab) {
        var tabs = document.querySelectorAll('.tab-content');
        tabs.forEach(function (tabContent) {
            tabContent.classList.remove('active');
        });

        document.getElementById(tab + '-content').classList.add('active');
        currentPage = 1;
        paginateTable(tab + '-table');
    }

    function paginateTable(tableId) {
        let table = document.getElementById(tableId);
        let rows = table.querySelectorAll('tbody tr');
        let totalPages = Math.ceil(rows.length / rowsPerPage);
        
        // Hide all rows
        rows.forEach((row, index) => {
            row.style.display = 'none';
            if (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) {
                row.style.display = '';
            }
        });

        // Update page number and disable/enable buttons
        document.getElementById('page-num-' + tableId.split('-')[0]).textContent = currentPage;
        document.getElementById('prev-btn').classList.toggle('disabled', currentPage === 1);
        document.getElementById('next-btn').classList.toggle('disabled', currentPage === totalPages);
    }

    function changePage(tab, direction) {
        let totalPages = Math.ceil(document.getElementById(tab + '-table').querySelectorAll('tbody tr').length / rowsPerPage);

        if (direction === 'next' && currentPage < totalPages) {
            currentPage++;
        } else if (direction === 'prev' && currentPage > 1) {
            currentPage--;
        }

        paginateTable(tab + '-table');
    }

    // Initialize pagination for all tabs
    paginateTable('borrowed-records-table');
    paginateTable('pending-request-table');
    paginateTable('record-of-borrowed-items-table');
</script>
    <script>
    let sortDirection = { 0: 'asc', 1: 'asc', 2: 'asc', 3: 'asc', 4: 'asc', 5: 'asc', 6: 'asc', 7: 'asc', 8: 'asc' };

function sortTable(columnIndex) {
    let table = document.getElementById("borrowed-records-table");
    let rows = Array.from(table.querySelectorAll("tbody tr"));
    let sortedRows;

    // Toggle the sort direction
    sortDirection[columnIndex] = sortDirection[columnIndex] === 'asc' ? 'desc' : 'asc';

    // Sorting rows based on column index and sort direction
    sortedRows = rows.sort((rowA, rowB) => {
        let cellA = rowA.cells[columnIndex].textContent.trim();
        let cellB = rowB.cells[columnIndex].textContent.trim();

        if (columnIndex === 4 || columnIndex === 8) {
            // For date columns, we need to compare as Date objects
            cellA = new Date(cellA);
            cellB = new Date(cellB);
        }

        // Comparing in ascending or descending order
        return (sortDirection[columnIndex] === 'asc' ? cellA > cellB : cellA < cellB) ? 1 : -1;
    });

    // Append sorted rows back to the table body
    sortedRows.forEach(row => table.querySelector("tbody").appendChild(row));

    // Update the sort arrows
    let headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        header.classList.remove('asc', 'desc');
        if (index === columnIndex) {
            header.classList.add(sortDirection[columnIndex]);
        }
    });
}
    </script>
</body>
</html>
